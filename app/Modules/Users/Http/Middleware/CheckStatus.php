<?php

namespace App\Modules\Users\Http\Middleware;

use Auth;
use Closure;

class Checkstatus
{
    public function handle($request, Closure $next)
    {
        if(Auth::user() && Auth::user()->isAdmin())
        {
            session_start();
            $_SESSION['admin'] = true;
            return $next($request);
        }
        else {
            return redirect('/');
        }
    }
}