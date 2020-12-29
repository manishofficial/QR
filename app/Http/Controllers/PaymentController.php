<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PayPal\Api\Payment;
use paytm\paytmchecksum\PaytmChecksum;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $id = $request->id;
        $data['plan'] = $plan = Plan::find($id);
        if (!$plan) abort(404);

        if(isset(auth()->user()->current_plans[0]) && auth()->user()->current_plans[0]->plan_id==$id){
          abort(404);
        }

        return view('payment.index', $data);
    }

    public function process(Request $request)
    {
        $request->validate([
            'plan' => 'required|exists:plans,id',
            'payment_type' => 'required|in:card,paypal,offline,paytm',
        ]);
        $plan = Plan::find($request->plan);

        if(isset(auth()->user()->current_plans[0]) && auth()->user()->current_plans[0]->plan_id==$plan->id){
            abort(404);
        }

        $expiredDate = null;
        if ($plan->recurring_type == 'weekly') {
            $expiredDate = now()->addWeek();
        } else if ($plan->recurring_type == 'monthly') {
            $expiredDate = now()->addMonth();
        } else if ($plan->recurring_type == 'yearly') {
            $expiredDate = now()->addYear();
        }

        $userPlan = new UserPlan();
        $userPlan->user_id = auth()->id();
        $userPlan->plan_id = $plan->id;
        $userPlan->start_date = now();
        $userPlan->expired_date = $expiredDate;
        $userPlan->is_current = 'no';
        $userPlan->payment_method = $request->payment_type;
        $userPlan->cost = $plan->cost;
        $userPlan->recurring_type = $plan->recurring_type;
        $userPlan->table_limit = $plan->table_limit;
        $userPlan->restaurant_limit = $plan->restaurant_limit;
        $userPlan->item_limit = $plan->item_limit;
        $userPlan->status = 'pending';
        $userPlan->save();

        notification('plan',$plan->id,$userPlan->user_id,"A new plan request has been placed");

        if ($request->payment_type == 'paypal') {
            $payment = $this->paypalPayment($userPlan, $plan);
            if ($payment)
                return redirect()->to($payment->getApprovalLink());
            else
                return redirect()->route('plan.list')->withErrors(['msg' => trans('layout.message.invalid_payment')]);

        }
        else if ($request->payment_type == 'card'){
           try {
               $payment = $this->stripePayment($plan, $request);
                UserPlan::where(['user_id' => $userPlan->user_id, 'is_current' => 'yes'])->update(['is_current' => 'no']);
                $userPlan->status = 'approved';
                $userPlan->is_current = 'yes';
                $userPlan->transaction_id = $payment->id;
                $userPlan->save();

                return redirect()->route('plan.list')->with('success', trans('layout.message.play_change_success'));
            } catch (\Exception $ex) {
               Log::error($ex);
                return redirect()->route('plan.list')->withErrors(['msg' => trans('layout.message.invalid_payment')]);
            }

        }
        else if ($request->payment_type == 'offline') {
            $userPlan->transaction_id = $request->transaction_id;
            $userPlan->other_info = json_encode($request->only('bank_name', 'bank_branch', 'account_name', 'account_number', 'reference', 'payment_type'));
            $userPlan->save();
            return redirect()->route('plan.list')->with('success', trans('layout.message.request_received'));

        }
        else if($request->payment_type=='paytm'){
            try {
                $paytmData=$this->payTmPayment($plan,$request,$userPlan);
                return view('payment.paytm',$paytmData);
            }catch (\Exception $ex){
                Log::error($ex);
                return redirect()->route('plan.list')->withErrors(['msg' => trans('layout.message.invalid_payment')]);

            }

        }
    }

    public function processSuccess(Request $request)
    {

        $credentials = json_decode(get_settings('payment_gateway'));
        if (!$credentials->paypal_client_id || !$credentials->paypal_secret_key) {
            return redirect()->route('plan.list')->withErrors(['msg' => trans('layout.message.invalid_payment')]);
        }
        $apiContext = $this->getPaypalApiContext($credentials->paypal_client_id, $credentials->paypal_secret_key);

        $paymentId = $request->paymentId;
        $user_plan_id = $request->plan;
        $user = $request->user;
        if (!$paymentId || !$user_plan_id || !$user) {
            return redirect()->route('plan.list')->withErrors(['msg' => trans('layout.message.invalid_payment')]);
        }

        try {
            $payment = Payment::get($paymentId, $apiContext);
        } catch (\Exception $ex) {
            exit(1);
        }

        if (!$payment) return redirect()->route('plan.list')->withErrors(['msg' => trans('layout.message.invalid_payment')]);

        $url = $payment->getRedirectUrls();
        $parsed_url = parse_url($url->getReturnUrl());
        $query_string = $parsed_url["query"];
        parse_str($query_string, $array_of_query_string);

        if ($array_of_query_string["plan"] != $user_plan_id || $array_of_query_string["user"] != $user || $array_of_query_string['paymentId'] != $paymentId) {
            return redirect()->route('plan.list')->withErrors(['msg' => trans('layout.message.invalid_payment')]);
        }

        $userPlan = UserPlan::where(['id' => $user_plan_id, 'user_id' => $user])->where(function ($q) use ($paymentId) {
            $q->whereNotIn('transaction_id', [$paymentId])->orWhereNull('transaction_id');
        })->first();

        if (!$userPlan) {
            return redirect()->route('plan.list')->withErrors(['msg' => trans('layout.message.invalid_payment')]);
        }
        UserPlan::where(['user_id' => $user, 'is_current' => 'yes'])->update(['is_current' => 'no']);

        $userPlan->status = 'approved';
        $userPlan->is_current = 'yes';
        $userPlan->transaction_id = $paymentId;
        $userPlan->save();

        return redirect()->route('plan.list')->with('success', trans('layout.message.play_change_success'));

    }

    public function processCancelled()
    {
        return redirect()->route('plan.list')->withErrors(['msg' => "Payment has been cancelled"]);
    }

    function paypalPayment($userPlan, $plan)
    {
        $credentials = json_decode(get_settings('payment_gateway'));
        if (!$credentials->paypal_client_id || !$credentials->paypal_secret_key) {
            return redirect()->route('plan.list')->withErrors(['msg' => trans('layout.message.invalid_payment')]);
        }
        $apiContext = $this->getPaypalApiContext($credentials->paypal_client_id, $credentials->paypal_secret_key);
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($plan->cost);
        $amount->setCurrency(get_currency()); //TODO:: get the currency

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.process.success', ['plan' => $userPlan->id, 'user' => $userPlan->user_id]))
            ->setCancelUrl(route('payment.process.cancel'));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            return $payment;
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }
        return null;
    }

    function getPaypalApiContext($client_id, $secret_key)
    {

        return new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $client_id,     // ClientID
                $secret_key      // ClientSecret
            )
        );
    }

    function stripePayment($plan, $req)
    {
        $credentials = json_decode(get_settings('payment_gateway'));
        if (!$credentials->stripe_publish_key || !$credentials->stripe_secret_key) {
            throw new \Exception(trans('layout.message.invalid_payment'));
        }

        $stripe = new \Stripe\StripeClient($credentials->stripe_secret_key);

        return $stripe->charges->create([
            'amount' => $plan->cost * 100,
            'currency' => get_currency(),
            'source' => $req->stripeToken,
            'description' => 'Change plan to ' . $plan->title,
        ]);
    }

    function payTmPayment($plan, $req,$userPlan){
        $credentials = json_decode(get_settings('payment_gateway'));
        if (!$credentials->paytm_environment || !$credentials->paytm_mid || !$credentials->paytm_secret_key || !$credentials->paytm_website || !$credentials->paytm_txn_url) {
            throw new \Exception(trans('layout.message.invalid_payment'));
        }

        $paytmParams = array();

        $orderId="PLANORDERID_".$userPlan->id;
        $mid=$credentials->paytm_mid;
        $paytmParams["body"] = array(
            "requestType"   => "Payment",
            "mid"           => $mid,
            "websiteName"   => $credentials->paytm_website,
            "orderId"       => $orderId,
            "callbackUrl"   => route('payment.paytm.redirect'),
            "txnAmount"     => array(
                "value"     => $plan->cost,
                "currency"  => "INR",
            ),
            "userInfo"      => array(
                "custId"    => "CUST_".$userPlan->user_id,
            ),
        );

        /*
* Generate checksum by parameters we have in body
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
*/
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $credentials->paytm_secret_key);

        $paytmParams["head"] = array(
            "signature"    => $checksum
        );
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        if($credentials->paytm_environment=='staging'){
            /* for Staging */
            $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=".$mid."&orderId=".$orderId;

        }

        if($credentials->paytm_environment=='production' ){
            /* for Production */
             $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=".$mid."&orderId=".$orderId;

        }


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);

        $response=json_decode($response);
        if(!isset($response->body) || !isset($response->body->resultInfo) || $response->body->resultInfo->resultStatus!='S'){
            throw new \Exception(trans('layout.message.invalid_payment'));
        }
       

        $data['response']=$response;
        $data['mid']=$mid;
        $data['order_id']=$orderId;
       return $data;

    }

    function processPaytmRedirect(Request $request){

        if(!$request->ORDERID || !$request->TXNID || !$request->TXNAMOUNT || !$request->STATUS){
            return redirect()->route('login')->withErrors(['msg' => trans('layout.message.invalid_payment')]);
        }

        $credentials = json_decode(get_settings('payment_gateway'));
        if (!$credentials->paytm_secret_key) {
            return redirect()->route('login')->withErrors(['msg' => trans('layout.message.invalid_payment')]);
        }

        $paytmParams = $_POST;

        $paytmChecksum = $_POST['CHECKSUMHASH'];
        unset($paytmParams['CHECKSUMHASH']);

        $isVerifySignature = PaytmChecksum::verifySignature($paytmParams, $credentials->paytm_secret_key, $paytmChecksum);
        if(!$isVerifySignature) return redirect()->route('login')->withErrors(['msg' => trans('layout.message.invalid_payment')]);


        $orderId=$request->ORDERID;
        $orderId=explode('_',$orderId)[1];

        $userPlan=UserPlan::find($orderId);
        if(!$userPlan) return redirect()->route('login')->withErrors(['msg' => trans('layout.message.invalid_payment')]);

        if($request->TXNAMOUNT!=format_number($userPlan->cost,2)) return redirect()->route('login')->withErrors(['msg' => trans('layout.message.invalid_payment')]);

        if($request->STATUS != 'TXN_SUCCESS') return redirect()->route('login')->withErrors(['msg' => trans('layout.message.cancel_payment')]);

        UserPlan::where(['user_id' => $userPlan->user_id, 'is_current' => 'yes'])->update(['is_current' => 'no']);
        $userPlan->status = 'approved';
        $userPlan->is_current = 'yes';
        $userPlan->transaction_id = $request->TXNID;
        $userPlan->save();

        return redirect()->route('login')->with('success', trans('layout.message.play_change_success'));

    }

}
