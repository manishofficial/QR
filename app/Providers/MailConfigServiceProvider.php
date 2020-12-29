<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $mailSetting = json_decode(get_settings('email_setting'));
        if ($mailSetting) {
            $config = array(
                'driver' => 'smtp',
                'host' => $mailSetting->host,
                'port' => $mailSetting->port,
                'from' => array('address' => $mailSetting->email_from, 'name' => $mailSetting->name),
                'encryption' => $mailSetting->encryption_type,
                'username' => $mailSetting->username,
                'password' => $mailSetting->password,
            );
            Config::set('mail', $config);
        }
    }
}
