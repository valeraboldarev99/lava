<?php

use Illuminate\Support\Facades\Route;

Route::group([
        'prefix' => Localization::locale(),
        'middleware' => 'setLocale'], function() {

    $namespace = 'App\Modules\Contacts\Http\Controllers';

    Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
    // admin
        Route::group(['middleware' => ['auth', 'status'],
                'prefix' => config('cms.url.admin_prefix'),
                'as' => config('cms.admin_prefix'),
                'namespace' => 'Admin'], function() {

            Route::resource('/contacts', 'IndexController');
        });

    //user
        Route::resource('contacts', 'IndexController');

        Route::post('contacts-modalForm', 'IndexController@modalForm')->name('contacts.modalForm');
        Route::get('contacts-modal', 'IndexController@modal')->name('contacts.modal');
     });
 });
