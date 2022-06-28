<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Modules\Users\Http\Controllers')
		->middleware(['web'])
		->group(function(){
// auth
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// admin auth
    Route::get(config('cms.url.admin_auth'), 'Auth\LoginController@showAdminLoginForm')->name('adminpanel');

// user
    Route::group(['middleware' => ['auth']], function() {
    	Route::get('/user/index', 'IndexController@index');
    });

//admin
	Route::group(['middleware' => ['auth', 'status'], 
			'prefix' => config('cms.url.admin_prefix'), 
			'as' => config('cms.admin_prefix'),
			'namespace' => 'Admin'], function() {

		Route::resource('users', 'IndexController');
	});
});