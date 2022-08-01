<?php

use App\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Modules\Settings\Models\Settings;
use App\Modules\Structure\Models\Structure;

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

if(!function_exists('getPage')) {
    function getPage()
    {
        $slug = str_replace(URL::to('/') . '/', '', url()->current());
        if(home() == $slug)
        {
            $page = Structure::where('slug', '')->first();
        }
        else {
            $str = strpos($slug, "/");
            if ($str) {
                $slug = substr($slug, $str + 1, strlen($slug));
            }
            $page = Structure::where('slug', $slug)->first();
        }
        return $page;
    }
}

