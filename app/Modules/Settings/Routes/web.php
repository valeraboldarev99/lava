<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\Settings\Http\Controllers';

Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
// admin
	Route::group(['middleware' => ['auth', 'status'],
			'prefix' => config('cms.url.admin_prefix'),
			'as' => config('cms.admin_prefix'),
			'namespace' => 'Admin'], function() {

		Route::resource('/settings', 'IndexController');
	});

//user
	Route::resource('/settings', 'IndexController');
});