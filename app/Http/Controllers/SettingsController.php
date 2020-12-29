<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\Plan;
use App\Models\RestaurantPaymentGateway;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SettingsController extends Controller
{
    public function settings()
    {
        $data['admin'] = $user = auth()->user();
        $data['emailTemplateReg'] = EmailTemplate::where('type', 'registration')->first();
        $data['emailTemplatePass'] = EmailTemplate::where('type', 'forget_password')->first();
        $data['emailTemplateOrderPlaced'] = EmailTemplate::where('type', 'order_placed')->first();
        $data['emailTemplateOrderStatus'] = EmailTemplate::where('type', 'order_status')->first();
        $data['emailTemplatePlanRequest'] = EmailTemplate::where('type', 'plan_request')->first();
        $data['emailTemplatePlanAccepted'] = EmailTemplate::where('type', 'plan_accepted')->first();
        $data['emailTemplatePlanExpire'] = EmailTemplate::where('type', 'plan_expired')->first();
        //Email Settings
        $emailSetting = Setting::where('name', 'email_setting')->first();
        if ($emailSetting) {
            $data['email_setting'] = json_decode($emailSetting->value);
            $data['email_setting_id'] = $emailSetting->id;
        }
        //site settings
        $sidebarSettings = Setting::where('name', 'site_setting')->first();
        if ($sidebarSettings) {
            $data['site_setting'] = json_decode($sidebarSettings->value);
            $data['site_setting_id'] = $sidebarSettings->id;
        }
        $paymentGateway = Setting::where('name', 'payment_gateway')->first();
        if ($paymentGateway) {
            $data['payment_gateway'] = json_decode($paymentGateway->value);
            $data['payment_gateway_id'] = $paymentGateway->id;
        }
        $smsGateway = Setting::where('name', 'sms_gateway')->first();
        if ($smsGateway) {
            $data['sms_gateway'] = json_decode($smsGateway->value);
            $data['sms_gateway_id'] = $smsGateway->id;
        }

        $localSetting = Setting::where('name', 'local_setting')->first();
        if ($localSetting) {
            $data['local_setting'] = json_decode($localSetting->value);
            $data['local_setting_id'] = $localSetting->id;
        }
        // dd($data);

        $data['permissions'] = Permission::all();
        $data['admin_permissions'] = Role::findByName('admin')->getAllPermissions()->pluck('name')->toArray();
        $data['rest_owner_permissions'] = Role::findByName('restaurant_owner')->getAllPermissions()->pluck('name')->toArray();
        $data['customer_permissions'] = Role::findByName('customer')->getAllPermissions()->pluck('name')->toArray();

        return view('settings.index', $data);
    }

    public function general(Request $request)
    {
        $user = auth()->user();


        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'picture' => 'image',

        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        if ($request->hasfile('picture')) {

            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/'), $filename);
            $user->picture = $filename;
        } else {

            $user->picture = $user->picture ? $user->picture : '';
        }
        $user->save();

        return redirect()->back()->with('success', trans('layout.message.setting_update'));
    }

    public function local_settings(Request $request)
    {
        $user = auth()->user();


        $request->validate([
            'language' => 'required',
            'date_time_format' => 'required',
            'date_time_separator' => 'required',
            'timezone' => 'required',
            'decimal_format' => 'required',
            'currency_symbol' => 'required',
            'currency_symbol_position' => 'required',
            'thousand_separator' => 'required',
            'decimals' => 'required',

        ]);
        $availableLang = get_available_languages();
        $type = $request->language;
        if (!in_array($type, $availableLang)) return abort(400);

        session()->put('locale', $type);
        app()->setLocale($type);

        $localSetting = $request->only('thousand_separator', 'decimals', 'language', 'date_time_format', 'date_time_separator', 'timezone', 'decimal_format', 'currency_symbol', 'currency_code', 'currency_symbol_position');
        $setting = isset($request->local_setting_id) ? Setting::find($request->local_setting_id) : new Setting();
        $setting->name = 'local_setting';
        $setting->value = json_encode($localSetting);
        $setting->save();
        cache()->flush();

        return redirect()->back()->with('success', trans('layout.message.setting_update'));
    }

    public function password_update(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'old_password' => 'required',
            'confirm_password' => 'required',
        ]);

        if (Hash::check($request->old_password, $admin->password) && $request->new_password == $request->confirm_password) {

            $admin->password = bcrypt($request->new_password);
            $admin->save();

            return redirect()->back()->with('success', trans('layout.message.setting_update'));
        }

        return redirect()->back()->with(['status' => 'fail', 'massege' => 'Invalid password']);
    }

    public function settings_store(Request $request)
    {


        $request->validate([
            'password' => 'required',
            'host' => 'required',
            'port' => 'required',

        ]);
        cache()->flush();
        $emailSettings = $request->only('host', 'username', 'email_from', 'name', 'password', 'port', 'encryption_type');

        $from = "Picotech Support <demo@picotech.app>";
        $to = "Picotech Support <demo@picotech.app>";
        $subject = "Hi!";
        $body = "Hi,\n\nHow are you?";

        $host = $request->host;
        $port = $request->port;
        $username = $request->username;
        $password = $request->password;
        $config = array(
            'driver' => 'smtp',
            'host' => $host,
            'port' => $port,
            'from' => array('address' => $request->email_from, 'name' => $request->name),
            'encryption' => $request->encryption_type,
            'username' => $username,
            'password' => $password,
        );
        Config::set('mail', $config);

        try {
            Mail::send('sendMail', ['htmlData' => $body], function ($message) {
                $message->to("tuhin.picotech@gmail.com")->subject
                ("Setting check");
            });
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(['msg' => trans('Invalid email credentials')]);
        }

        $setting = isset($request->setting_id) ? Setting::find($request->setting_id) : new Setting();
        $setting->name = 'email_setting';
        $setting->value = json_encode($emailSettings);
        $setting->save();


        return redirect()->back()->with('success', trans('layout.message.setting_update'));
    }

    public function site_settings(Request $request)
    {
        $request->validate([
            'fav_icon' => 'image',
            'logo' => 'image',
        ]);

        $preSetting = Setting::find($request->settings_id);
        if ($preSetting) {
            $preSetting = json_decode($preSetting->value);
        }

        $fav_icon = isset($preSetting->favicon) ? $preSetting->favicon : '';
        $logo = isset($preSetting->logo) ? $preSetting->logo : '';

        $sidebarSettings = $request->only('name');

        if ($request->hasfile('fav_icon')) {

            $file = $request->file('fav_icon');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'f.' . $extension;
            $file->move(public_path('uploads/'), $filename);

            $fav_icon = $filename;
        }

        if ($request->hasfile('logo')) {

            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'l.' . $extension;
            $file->move(public_path('uploads/'), $filename);

            $logo = $filename;
        }

        $sidebarSettings['favicon'] = $fav_icon;
        $sidebarSettings['logo'] = $logo;


        $setting = isset($request->settings_id) ? Setting::find($request->settings_id) : new Setting();
        $setting->name = 'site_setting';
        $setting->value = json_encode($sidebarSettings);
        $setting->save();
        cache()->flush();
        return redirect()->back()->with('success', trans('layout.message.setting_update'));
    }

    public function templateStore(Request $request)
    {
        $emailTemplate = isset($request->emailTemplateID) ? EmailTemplate::find($request->emailTemplateID) : new EmailTemplate();

        $emailTemplate->type = $request->type;
        $emailTemplate->subject = $request->subject;
        $emailTemplate->body = $request->body;
        $emailTemplate->status = 'active';

        $emailTemplate->save();
        cache()->flush();
        return redirect()->back()->with('success', trans('layout.message.setting_update'));
    }

    public function paymentGateway(Request $request)
    {
        $user = auth()->user();
        if ($user->type == 'admin') {
            $paymentGateway = $request->only('paypal_client_id', 'paypal_secret_key', 'stripe_publish_key', 'stripe_secret_key', 'paypal_status', 'stripe_status',
                'paytm_environment',  'paytm_mid',  'paytm_secret_key',  'paytm_website',  'paytm_txn_url','paytm_status',
                'offline_status');
            $setting = isset($request->payment_gateway_id) ? Setting::find($request->payment_gateway_id) : new Setting();
            $setting->name = 'payment_gateway';
            $setting->value = json_encode($paymentGateway);
            $setting->save();
        } else {
            $paymentGateway = $request->only('paypal_client_id', 'paypal_secret_key', 'stripe_publish_key', 'stripe_secret_key', 'paypal_status', 'stripe_status',
                'paytm_environment',  'paytm_mid',  'paytm_secret_key',  'paytm_website',  'paytm_txn_url','paytm_status','offline_status');
            $setting = isset($request->rest_payment_gateway_id) ? RestaurantPaymentGateway::where(['id'=>$request->rest_payment_gateway_id,'user_id'=>$user->id])->first() : new RestaurantPaymentGateway();
            $setting->user_id = $user->id;
            $setting->value = json_encode($paymentGateway);
            $setting->save();
        }
        cache()->flush();
        return redirect()->back()->with('success', trans('layout.message.setting_update'));
    }

    public function smsGateway(Request $request)
    {
        $smsGateway = $request->only('twilio_sid', 'twilio_token', 'voyager_api', 'voyager_api_secret', 'signalwire_project_id', 'signalware_url', 'signalware_token');
        $setting = isset($request->sms_gateway_id) ? Setting::find($request->sms_gateway_id) : new Setting();
        $setting->name = 'sms_gateway';
        $setting->value = json_encode($smsGateway);
        $setting->save();

        cache()->flush();
        return redirect()->back()->with('success', trans('layout.message.setting_update'));
    }

    public function permissionUpdate(Request $request)
    {
        /*
        $role = Role::findByName('admin');
        $role->syncPermissions($request->admin_permission);*/

        if (!array_intersect(get_restaurant_permissions(), $request->rest_owner_permission)) {
            return redirect()->back()->withErrors(['msg' => trans('layout.message.invalid_request')]);
        }

        if (!array_intersect(get_customer_permissions(), $request->customer_permission)) {
            return redirect()->back()->withErrors(['msg' => trans('layout.message.invalid_request')]);
        }

        $role = Role::findByName('restaurant_owner');
        $role->syncPermissions($request->rest_owner_permission);

        $role = Role::findByName('customer');
        $role->syncPermissions($request->customer_permission);

        return redirect()->back()->with('success', trans('layout.message.setting_update'));
    }

    public function permissionGenerate()
    {
        $newPlan = new Plan();
        $newPlan->title = 'default';
        $newPlan->recurring_type = 'onetime';
        $newPlan->status = 'inactive';
        $newPlan->save();

        $adminData = [
            "restaurant_manage",
            "order_manage",
            "item_manage",
            "plan_manage",
            "table_manage",
            "dashboard",
            "general_setting",
            "change_password",
            "site_setting",
            "email_setting",
            "email_template_setting",
            "payment_gateway_setting",
            "sms_gateway_setting",
            "order_payment_status_change",
            "order_list",
            "billing",
            "user_plan_change",
            "qr_manage",
            "category_manage",
            "role_permission",
        ];

        $restaurantData = [
            "restaurant_manage",
            "order_manage",
            "item_manage",
            "plan_manage",
            "table_manage",
            "dashboard",
            "general_setting",
            "change_password",
            "order_payment_status_change",
            "order_list",
            "billing",
            "category_manage",
        ];

        $customerData = [
            "order_list",
        ];

        $roleName = 'admin';
        $role = Role::findOrCreate($roleName);
        $user = User::where('type', 'admin')->first();
        if ($user) {

            foreach ($adminData as $d) {
                $permission = Permission::findOrCreate($d);
                $role->givePermissionTo($permission);
            }
            $user->assignRole($roleName);

            $roleName = 'restaurant_owner';
            $role = Role::findOrCreate($roleName);
            foreach ($restaurantData as $d) {
                $permission = Permission::findOrCreate($d);
                $role->givePermissionTo($permission);
            }


            $roleName = 'customer';
            $role = Role::findOrCreate($roleName);
            foreach ($customerData as $d) {
                $permission = Permission::findOrCreate($d);
                $role->givePermissionTo($permission);
            }
        }
    }
}
