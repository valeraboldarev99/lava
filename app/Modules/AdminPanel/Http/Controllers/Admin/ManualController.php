<?php

namespace App\Modules\AdminPanel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManualController extends Controller
{
	public function __construct() {
	    $this->middleware('auth');
	    $this->middleware('status');
	}

    public function main()
    {
        return view('AdminPanel::manual.main');
    }
}