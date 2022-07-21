<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\Structure\Http\Controllers';

Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
// admin
	Route::group(['middleware' => ['auth', 'status'],
			'prefix' => config('cms.url.admin_prefix'),
			'as' => config('cms.admin_prefix'),
			'namespace' => 'Admin'], function() {

		Route::resource('/structure', 'IndexController');
	});

//user
	Route::resource('/structure', 'IndexController');
	// Route::get('{page:slug}', 'IndexController')->name('page');
});