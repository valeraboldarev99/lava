<?php

use App\Modules\Settings\Models\Settings;
use App\Helpers\PagesStructure;

if (!function_exists('home')) {
    function home()
    {
        return url('/' . getLang());
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

if(!function_exists('getLang')) {
    function getLang()
    {
        $locale = request()->segment(1, '');
        if($locale == config('cms.url.admin_prefix') || $locale == '')
        {
            $locale = config('app.locale');
        }
        if($locale && in_array($locale, config("localization.locales"))) {
            return $locale;
        }

        return config('app.locale');
    }
}

if(!function_exists('getPage')) {
    function getPage()
    {
        return PagesStructure::getPage();
    }
}

if(!function_exists('getUrl')) {
    function getUrl()
    {
        return implode('/', array_slice(request()->segments(), 0));
    }
}

if(!function_exists('adminLocale')) {
    function adminLocale($locale)
    {
        if(strpos(getUrl(), getLang()) == 0)
        {
            $url =  str_replace(getLang(), '', getUrl());
        }
        else {
            $url = getUrl();
        }

        if(strpos($url, '/') == 0)
        {
            $url = substr($url, 1, strlen($url));
        }
        $url = '/' . $locale .  '/' . $url;

        return $url;
    }
}

if(!function_exists('checkModelLocalization')) {
    function checkModelLocalization($model_name)
    {
        $result = config($model_name . '.settings.localization');

        if($result == NULL)
        {
            $result = false;
        }

        return $result;
    }
}