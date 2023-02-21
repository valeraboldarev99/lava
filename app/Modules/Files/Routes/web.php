<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\Files\Http\Controllers';

Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
// admin
    Route::group(['middleware' => ['auth', 'status'],
            'prefix' => config('cms.url.admin_prefix'),
            'as' => config('cms.admin_prefix'),
            'namespace' => 'Admin'], function() {

        Route::get('files/files', 'IndexController@filesView')->name('files.filesView');
        Route::get('files/images', 'IndexController@imagesView')->name('images.imagesView');
    });
 });

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});