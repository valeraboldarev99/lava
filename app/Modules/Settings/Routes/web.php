<?php

use Illuminate\Support\Facades\Route;

Route::group([
        'prefix' => Localization::locale(),
        'middleware' => 'setLocale'], function() {

	$namespace = 'App\Modules\Settings\Http\Controllers';

	Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
	// admin
		Route::group(['middleware' => ['auth', 'status'],
				'prefix' => config('cms.url.admin_prefix'),
				'as' => config('cms.admin_prefix'),
				'namespace' => 'Admin'], function() {

			Route::resource('/settings', 'IndexController');
			Route::post('/short_settings', 'IndexController@shortStore')->name('settings.short_store');
		});

	//user
		Route::resource('/settings', 'IndexController');
	});
});