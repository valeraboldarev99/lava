<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $langPrefix = ltrim($request->route()->getPrefix(), '/');
        $adminPrefix = strpos($langPrefix, config('cms.url.admin_prefix'));
        if($adminPrefix)
        {
            $langPrefix = str_replace(config('cms.url.admin_prefix'), '', $langPrefix);
        	$langPrefix = str_replace('/', '', $langPrefix);
        }
        if($langPrefix == config('app.locale') && !$adminPrefix)
        {
        	return redirect('/');
        }
        if($langPrefix == config('app.locale') && $adminPrefix)
        {
        	$url = str_replace(config('app.locale') . '/', '', $request->route()->uri);
        	return redirect($url);
        }

        if($langPrefix && in_array($langPrefix, config('localization.locales'))) {
            App::setLocale($langPrefix);
        }

        return $next($request);
    }
}