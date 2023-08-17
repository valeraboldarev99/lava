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
            Route::post('/news/change_file', 'IndexController@changeFile')->name('news.changeFile');                                            //changeFile
            Route::get('/news/download_file/{id}/{field}', 'IndexController@downloadFile')->name('news.downloadFile');                                            //downloadFile
            Route::post('/news/image-position', 'IndexController@positionImage')->name('news.positionImages');
            
            Route::get('/news/export/', 'IndexController@export')->name('news.export');
            Route::post('/news/import/', 'IndexController@import')->name('news.import');
            Route::resource('/news', 'IndexController');

            Route::post('/news/position/{id}/{direction}', 'IndexController@position')->name('news.position');
            Route::post('/news-file/position', 'IndexController@positionFile')->name('news_files.positionFile');
            // Route::post('/news-image/position/{entity}/{id}/{direction}', 'IndexController@positionFile')->name('news_images.positionFile');
        });

    //user
        Route::get('/news', 'IndexController@index')->name('news.index');
        Route::get('/news/{id}', 'IndexController@show')->name('news.show');

     });
 });
