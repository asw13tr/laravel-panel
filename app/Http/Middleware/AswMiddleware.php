<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Config;

$GLOBALS['configs'] = array();
$GLOBALS['configs']["is_login_admin"] = false;

class AswMiddleware{
    private $configColumns = [  'url', 'title', 'description', 'author', 'refresh', 'site_offline', 'site_offline_message', 'allow_register',
                                'allow_register_panel', 'contact_email', ''];

    public function handle($request, Closure $next){

        $configItems = Config::all();
        //$configArray = array
        if($configItems){
            foreach($configItems as $configItem){
                $GLOBALS['configs'][$configItem->key] = $configItem->val;
            }
        }

        if(Auth::check()){
            if(Auth::user()->level >= 2){
                $GLOBALS['configs']["is_login_admin"] = true;
            }
        }

        return $next($request);
    }
}
