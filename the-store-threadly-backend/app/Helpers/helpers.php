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