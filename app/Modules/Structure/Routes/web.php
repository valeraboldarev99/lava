<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\PagesStructure;
use App\Helpers\StructurePages;

Route::group([
        'prefix' => Localization::locale(),
        'middleware' => 'setLocale'], function() {

	$namespace = 'App\Modules\Structure\Http\Controllers';

	Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
	// admin
		Route::group(['middleware' => ['auth', 'status'],
				'prefix' => config('cms.url.admin_prefix'),
				'as' => config('cms.admin_prefix'),
				'namespace' => 'Admin'], function() {

                    Route::resource('/structure', 'IndexController');
                    Route::post('structure/position/{id}/{direction}', 'IndexController@positionStructure')->name('structure.position');
		});

	//user
		Route::resource('/structure', 'IndexController');

	//generate page routes
		foreach (PagesStructure::getPagesRoutes() as $route) {
			Route::get($route['slug'], 'IndexController@index')->name($route['route_name']);
		}
	});
});