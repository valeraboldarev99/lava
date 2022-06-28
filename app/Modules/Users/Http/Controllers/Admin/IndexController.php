<?php

namespace App\Modules\Users\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Modules\Users\Models\User;
use App\Http\Controllers\Controller;
use App\Modules\AdminPanel\Http\Controllers\MainController;

class IndexController extends MainController
{
	protected $viewPrefix = 'Users::';
    protected $routePrefix = 'admin.users.';

	public function getModel()
	{
		return new User();
	}
}