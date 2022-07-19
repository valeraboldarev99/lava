<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Modules\Users\Http\Controllers')
		->middleware(['web'])
		->group(function(){
// auth
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    //выход
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    // регистрация
    Route::get('register', 'Auth\RegisterController@registerForm')->name('registerForm');
    Route::post('register', 'Auth\RegisterController@store')->name('register');
    // отправка письма для сброса пароля
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // Маршруты сброса пароля
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// admin auth
    Route::get(config('cms.url.admin_auth'), 'Auth\LoginController@showAdminLoginForm')->name('adminpanel');

// user
    Route::group(['middleware' => ['auth']], function() {
		Route::resource('users', 'IndexController');
    });

//admin
	Route::group(['middleware' => ['auth', 'status'], 
			'prefix' => config('cms.url.admin_prefix'), 
			'as' => config('cms.admin_prefix'),
			'namespace' => 'Admin'], function() {

		Route::resource('users', 'IndexController');
	});
});