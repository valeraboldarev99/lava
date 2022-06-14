<?php

namespace App\Modules\Admins\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class MainController extends AdminBaseController
{
    public function index()
    {
        return view('Admins::users.admin.main');
    }
}