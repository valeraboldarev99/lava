<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Structure\Models\Structure;

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

//generate page routes
	foreach (Structure::getPagesRoutes() as $route) {
		Route::get($route, 'IndexController@show')->name($route);
	}
});