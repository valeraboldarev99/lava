<?php

use App\Facades\Route;
use App\Modules\Settings\Models\Settings;

if (!function_exists('home')) {
    function home()
    {
        return url('/');
    }
}

if (!function_exists('modules_all')) {
    function modules_all()
    {
        return array_diff(scandir(config('modules.path')), array('.','..'));
    }
}

if(!function_exists('getSetting')) {
    function getSetting($slug)
    {
        return Settings::where('slug', $slug)->where('active', 1)->value('content');
    }
}