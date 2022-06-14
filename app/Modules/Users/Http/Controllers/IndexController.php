<?php

namespace App\Modules\Users\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Modules\Users\Models\User;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	public function __construct ()
	{
	    $this->middleware('auth');
	}

	public function index()
	{
		$user = Auth::user();
	    return view('Users::index', [
	    	'user'	=> $user,
	    ]);
	}
}