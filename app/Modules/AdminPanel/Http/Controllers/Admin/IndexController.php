<?php

namespace App\Modules\AdminPanel\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	public function __construct() {
	    $this->middleware('auth');
	    $this->middleware('status');
	}

	public function main()
	{
		if(Auth::user()->isAdmin())
		{
	    	return view('AdminPanel::main');
		}
	    else {
	    	return redirect('/');
	    }
	}
}