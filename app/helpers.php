<?php

use App\Facades\Route;


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

if (!function_exists('adminform_value')) {
    function adminform_value($entity, $attr)
    {
        if(isset($entity) && $attr)
        {
            return $attr;
        }
        else {
            return '';
        }
        return array_diff(scandir(config('modules.path')), array('.','..'));
    }
}