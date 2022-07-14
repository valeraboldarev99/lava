<?php

namespace App\Modules\Users\Http\Controllers\Admin;

use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Modules\Users\Models\Users;
use App\Modules\Users\Models\Role;
use App\Modules\Users\Models\UserRole;
use App\Http\Controllers\Controller;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

class IndexController extends AdminMainController
{
    protected $viewPrefix = 'Users';
    protected $routePrefix = 'admin.users.';

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
        ];
    }

    public function index()
    {
        $users = Users::join('user_roles', 'users.id', 'user_roles.user_id')
                        ->join('roles', 'user_roles.role_id', 'roles.id')
                        ->select('users.*', 'roles.name as role_name')
                        ->paginate($this->perPage);

        return view($this->getIndexViewName(), [
            'entities' => $users
        ]);
    }

    public function create()
    {
        $entity = $this->getModel();
        $roles = Role::pluck('name', 'id');

        return view($this->getFormViewName(), [
            'entity'    => $entity,
            'roles'     => $roles,
        ]);
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
                'role_id' => (int)$request['role'],
            ]);
            if (!$user_role) {
                return back()->withErrors(['msg' => "Ошибка создания Роли пользователя"])->withInput();
            } else {
                return redirect()->route($this->routePrefix . 'edit', $user->id)->with('message', trans('AdminPanel::adminpanel.messages.store'));
            }
        }
    }

    public function edit($id)
    {
        $roles = Role::pluck('name', 'id');
        $entity = $this->getModel()->findOrFail($id);
        $entity->role = UserRole::where('user_id', $id)->pluck('role_id')->first();

        return view($this->getFormViewName(), [
            'routePrefix'   => $this->routePrefix,
            'entity'        => $entity,
            'roles'         => $roles,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->getRules($request, $id), $this->getMessages(), $this->getAttributes());

        $user = $this->getModel()->findOrFail($id);
        $user->update($request->all());

        if (!$user) {
            return back()->withErrors(['msg' => "Ошибка сохранения"])->withInput();
        } else {
            UserRole::where('user_id', $user->id)->update(['role_id' => (int)$request['role']]);

            return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.update'));
        }
    }
}