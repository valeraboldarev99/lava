<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\Search\Http\Controllers';

Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
// admin
    Route::group(['middleware' => ['auth', 'status'],
            'prefix' => config('cms.url.admin_prefix'),
            'as' => config('cms.admin_prefix')], function() {

        Route::get('search', 'IndexController@search')->name('search');
    });

//user
});
