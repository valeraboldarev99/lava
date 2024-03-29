<?php

namespace App\Modules\Users\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Modules\Users\Models\Role;
use App\Modules\Users\Models\Users;
use App\Modules\Users\Models\UserRole;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
	protected $viewPrefix = 'Users';

	public function __construct ()
	{
		$this->middleware('auth');
		$this->share();
	}

	public function getModel()
	{
		return new Users();
	}

    public function index()
    {
        return view($this->getIndexViewName(), [
            'items' => $this->getModel()->order()->filtered()->paginate($this->perPage),
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function userAccount()
    {
		$entity =  $this->getModel()->findOrFail(Auth::id());

        return view('Users::account', [
			'entity'        => $entity,
			'routePrefix'   => $this->routePrefix,
		]);
    }

	public function show($id)
	{
        if(Auth::id() != 1)
        {
            if($id == 1)
            {
                return redirect()->back();
            }
        }

		$entity =  $this->getModel()->findOrFail($id);
		$role_id = UserRole::where('user_id', $id)->pluck('role_id')->first();
		$entity->role = Role::where('id', $role_id)->pluck('name', 'id')->first();

		return view($this->getShowViewName(), [
			'entity'        => $entity,
			'checkUserId'	=> Auth::id() == $id,
			'routePrefix'   => $this->routePrefix,
		]);
	}

	public function edit($id)
	{
        if(Auth::id() != 1)
        {
            if($id == 1)
            {
                return redirect()->back();
            }
        }
		return view('Users::edit', [
			'entity'        => $this->getModel()->findOrFail($id),
			'routePrefix'   => $this->routePrefix,
		]);
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, $this->getRules($request, $id), $this->getMessages(), $this->getAttributes());

		$entity = $this->getModel()->findOrFail($id);
		$entity->update($request->all());

		return redirect()->back()->with('message', 'Данные обновлены');
	}

    public function destroy($id)
    {
        abort(404);
    }

	public function getRules()
	{
		return [
			'name' => 'sometimes|required',
			'password' => 'confirmed',
		];
	}
}