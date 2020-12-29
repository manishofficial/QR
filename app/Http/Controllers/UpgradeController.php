<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpgradeController extends Controller
{
    public function process()
    {
        auth()->logout();
        cache()->flush();

        if(env('APP_VERSION') != 1.2) return redirect()->route('login')->withErrors(['msg'=>'Not a valid version to upgrade']);

        if (env('APP_DEBUG') && env('APP_VERSION')==1.2) {
            echo "<h1>Upgrading...</h1>";
            $sqlFile = Storage::disk('local')->get('upgrade/v1_1-v1_2.sql');

            if ($sqlFile) {
                try{
                    DB::unprepared($sqlFile);
                }catch (\Exception $ex){
                    return redirect()->route('login')->withErrors(['msg'=>'Failed! Please contact with administration']);
                }
            }
            echo "Database upgrade has been finished <br/>";
            echo "<a href='" . route('login') . "'>Back to login page</a>";
        }else{
            return redirect()->route('login')->withErrors(['msg'=>'Please enable APP_DEBUG']);
        }
    }
}
