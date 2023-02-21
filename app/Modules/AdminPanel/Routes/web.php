<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth', 'status'],
		'namespace' => 'App\Modules\AdminPanel\Http\Controllers\Admin'], function() {

	Route::get(config('cms.url.admin_panel'), 'IndexController@main')->name('admin_panel');
});