<?php

namespace App\Modules\Admins\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modules\Admins\Http\Controllers\MainBaseController;

abstract class AdminBaseController extends MainBaseController
{
    public function __construct() {
        // $this->middleware('auth');
        // $this->middleware('status');
    }
}