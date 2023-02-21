<?php

namespace App\Modules\Users\Http\Controllers\Auth;

use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Modules\Users\Models\Role;
use App\Modules\Users\Models\Users;
use App\Http\Controllers\Controller;
use App\Modules\Users\Models\UserRole;

class RegisterController extends Controller
{
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getModel()
    {
        return new Users();
    }

    public function getRules($request, $id = false)
    {
        return [
            'name' => 'sometimes|required',
            'email' => [
                'required', 'max:255', 'email',
                Rule::unique('users')->ignore($id)
            ],
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function registerForm()
    {
        return view('Users::auth.register');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->getRules($request), $this->getMessages(), $this->getAttributes());

        $user = $this->getModel()->create($request->all());

        if (!$user) {
            return back()->withErrors(['msg' => "Ошибка создания"])->withInput();
        } else {
            $user_role = UserRole::create([
                'user_id' => $user->id,
                'role_id' => '2',
            ]);
            if (!$user_role) {
                return back()->withErrors(['msg' => "Ошибка создания Роли пользователя"])->withInput();
            } else {
                Auth::login($user);
            }
        }
    }

    protected function getMessages()
    {
        return [];
    }

    protected function getAttributes()
    {
        $attributes = trans('AdminPanel::fields');

        return array_merge($attributes, $this->getCustomAttributes());
    }

    protected function getCustomAttributes() : array
    {
        return [];
    }
}
