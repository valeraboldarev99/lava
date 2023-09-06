<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => Localization::locale(),
    'middleware' => 'setLocale'], function() {
    
    $namespace = 'App\Modules\Search\Http\Controllers';

    Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
    // admin
        Route::group(['middleware' => ['auth', 'status'],
                'prefix' => config('cms.url.admin_prefix'),
                'as' => config('cms.admin_prefix'),
                'namespace' => 'Admin'], function() {

            Route::get('search', 'IndexController@search')->name('search');
        });

    //user
        Route::get('search', 'IndexController@search')->name('user.search');
    });
});