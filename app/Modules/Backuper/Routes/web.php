<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\Backuper\Http\Controllers';

Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
// admin
    Route::group(['middleware' => ['auth', 'status'],
            'prefix' => config('cms.url.admin_prefix'),
            'as' => config('cms.admin_prefix'),
            'namespace' => 'Admin'], function() {

        Route::get('/backuper', 'IndexController@index')->name('backuper.index');
        Route::post('/backuper/backupUploads', 'IndexController@backupUploads')->name('backuper.backupUploads');
        Route::post('/backuper/backupDataBase', 'IndexController@backupDataBase')->name('backuper.backupDataBase');
    });
});