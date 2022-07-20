<?php

namespace App\Modules\Users\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');

        return view('Users::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function setUserPassword($user, $password)
    {
        $user->password = $password;
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ];
    }
}
