<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
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
        $localSetting = json_decode(get_settings('local_setting'));
        $siteSetting = json_decode(get_settings('site_setting'));
        $config = [];
        if ($localSetting) {
            $config['timezone'] = isset($localSetting->timezone) ? $localSetting->timezone : 'UTC';
            config(['app.timezone' => $config['timezone']]);
        }
        if ($siteSetting) {
            $config['name'] = isset($siteSetting->name) ? $siteSetting->name : 'PicoQR';
            config(['app.name' => $config['name']]);
        }
    }
}
