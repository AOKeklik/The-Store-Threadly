<?php

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return app('settings')[$key] ?? $default;
    }
}

if (!function_exists('settings')) {
    function settings()
    {
        return app('settings'); 
    }
}

if(!function_exists("currency")){
    function currency($price){
        if(setting("site_currency_icon_position") == "right")
            return round($price, 2)." ".setting("site_currency_icon");
        else
            return setting("site_currency_icon")." ".round($price, 2);
    }
}