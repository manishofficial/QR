<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function registration()
    {
        return view('auth.registration');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:5',
        ]);


        $user = new  User();
        $user->name = $request->name;
        $user->email = $request->email;

        if (isset($request->type) && $request->type == 'customer') {
            $user->type = 'customer';
        } else {
            $user->type = 'restaurant_owner';
        }

        $user->password = bcrypt($request->password);
        $user->save();
        if (isset($request->type) && $request->type == 'customer') {
            $user->assignRole('customer');
        } else {
            $user->assignRole('restaurant_owner');

        }
        $plan = Plan::where('recurring_type', 'onetime')->first();

        $userPlan = new UserPlan();
        $userPlan->user_id = $user->id;
        $userPlan->plan_id = $plan->id;
        $userPlan->start_date = now();
        $userPlan->is_current = 'yes';
        $userPlan->recurring_type = $plan->recurring_type;
        $userPlan->status = 'approved';
        $userPlan->save();

        try {
            $emailTemplate = EmailTemplate::where('type', 'registration')->first();
            if ($emailTemplate) {
                $route = URL::temporarySignedRoute('verification.verify', now()->addHours(4), ['id' => $user->id, 'hash' => sha1($user->email)]);
                $regTemp = str_replace('{customer_name}', $user->name, $emailTemplate->body);
                $regTemp = str_replace('{click_here}', "<a href=" . $route . ">".trans('layout.click_here')."</a>", $regTemp);

                Mail::send('sendMail', ['htmlData' => $regTemp], function ($message) use ($user, $emailTemplate) {
                    $message->to($user->email)->subject
                    ($emailTemplate->subject);
                });
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
        auth()->login($user);

        return redirect()->route('dashboard')->with('success', trans('layout.message.registration_success'));

    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $remember = isset($request->remember_me) ? true : false;

        $credentials = $request->only('email', 'password');


        if (auth()->attempt($credentials, $remember)) {
            if(auth()->user()->type=='customer'){
                return redirect()->route('order.index');
            }
            return redirect()->intended('dashboard');

        } else
            return redirect()->back()->withErrors(['fail' => trans('auth.failed')]);

    }

    public function forgetPassword()
    {
        return view('auth.forget_password');
    }

    public function sendForgetPasswordCode(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) return redirect()->back()->withErrors(['msg' => trans('layout.message.user_not_found')]);
        $token = sha1($user->email);
        $data = [
            'email' => $user->email,
            'token' => $token
        ];
        DB::table('password_resets')->insert($data);

        try {
            $emailTemplate = EmailTemplate::where('type', 'forget_password')->first();
            if ($emailTemplate) {
                $route = URL::temporarySignedRoute('password.reset.form', now()->addHours(1), ['token' => $token]);
                $temp = str_replace('{customer_name}', $user->name, $emailTemplate->body);
                $temp = str_replace('{reset_url}', "<a href=" . $route . ">".trans('layout.click_here')."</a>", $temp);

                Mail::send('sendMail', ['htmlData' => $temp], function ($message) use ($user, $emailTemplate) {
                    $message->to($user->email)->subject
                    ($emailTemplate->subject);
                });
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }

        return redirect()->route('login')->with('success', trans('layout.message.reset_link_send'));

    }

    public function passwordResetForm($token)
    {
        $resetTable = DB::table('password_resets')->where('token', $token)->first();
        if (!$resetTable) {
            return redirect()->route('login')->withErrors(['msg' => trans('layout.message.token_expired')]);
        }

        $data['token'] = $token;
        return view('auth.new_password_form', $data);
    }

    public function passwordResetConfirm(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:5',
            'token' => 'required'
        ]);

        $resetTable = DB::table('password_resets')->where('token', $request->token)->first();
        if (!$resetTable) {
            return redirect()->route('login')->withErrors(['msg' => trans('layout.message.token_expired')]);
        }

        $user = User::where('email', $resetTable->email)->first();
        if (!$user) {
            return redirect()->route('login')->withErrors(['msg' => trans('layout.message.token_expired')]);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        DB::table('password_resets')->where('token', $request->token)->delete();
        return redirect()->route('login')->with('success', trans('layout.message.reset_successful'));

    }
}
