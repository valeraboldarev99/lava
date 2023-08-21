<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\AdminPanel\Http\Controllers';

Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
// admin
    Route::group(['middleware' => ['auth', 'status'],
            'prefix' => config('cms.url.admin_prefix'),
            'as' => config('cms.admin_prefix'),
            'namespace' => 'Admin'], function() {

        
        Route::get(config('cms.url.admin_panel'), 'IndexController@main')->name('admin_panel');

        Route::get('manual', function(){
            return view('AdminPanel::manual.main');
        })->name('manual');
        Route::get('manual/show/{type}/{name}', function($type, $name){
            return view('AdminPanel::manual.'. $type . '.' . $name);
        })->name('manual.show');
    });
//user Routes ...
});





