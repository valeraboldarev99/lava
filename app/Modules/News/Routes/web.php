<?php

use Illuminate\Support\Facades\Route;

Route::group([
        'prefix' => Localization::locale(),
        'middleware' => 'setLocale'], function() {

    $namespace = 'App\Modules\News\Http\Controllers';

    Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
    // admin
        Route::group(['middleware' => ['auth', 'status'],
                'prefix' => config('cms.url.admin_prefix'),
                'as' => config('cms.admin_prefix'),
                'namespace' => 'Admin'], function() {

            Route::delete('/news/deleteFile/{id}/{field}', 'IndexController@deleteFile')->name('news.deleteFile');
            Route::resource('/news', 'IndexController');
        });

    //user
        Route::resource('/news', 'IndexController');
     });
 });
