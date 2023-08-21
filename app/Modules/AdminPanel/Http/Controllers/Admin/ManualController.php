<?php

namespace App\Modules\AdminPanel\Http\Controllers\Admin;

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

    public function show($type, $name)
    {
        return view('AdminPanel::manual.'. $type . '.' . $name);
    }
}