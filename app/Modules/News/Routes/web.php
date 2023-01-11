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

            Route::delete('/news/deleteFile/{id}/{field}', 'IndexController@deleteFile')->name('news.deleteFile');              //delete single file or image
            Route::delete('/news/deleteMultiFiles/{entity_id}/{field}/{file_id}', 'IndexController@deleteMultiFiles')->name('news.deleteMultiFiles');   //delete multi files
            Route::post('/news/multi_uploader', 'IndexController@multiUploader')->name('news.multiUploader');                                            //multi uploading images


            Route::resource('/news', 'IndexController');
        });

    //user
        Route::resource('/news', 'IndexController');
     });
 });
