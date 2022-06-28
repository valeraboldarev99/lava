<?php
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