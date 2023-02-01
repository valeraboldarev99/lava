<?php

namespace App\Modules\Files\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	public function filesView()
	{
		return view('Files::admin.files');
	}

	public function imagesView()
	{
		return view('Files::admin.images');
	}
}