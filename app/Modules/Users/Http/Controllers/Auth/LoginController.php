<?php

namespace App\Modules\Users\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Modules\Users\Models\Users;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = null;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('Users::auth.login');
    }

    public function showAdminLoginForm()
    {
        return view('AdminPanel::auth.admin_auth');
    }

    protected function redirectTo(){
        if (Auth::user()->isAdmin()) {
            return $this->redirectTo = '/'. config('cms.url.admin_panel');
        }
        else {
            return home();
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required',
        ]);
    }
}
