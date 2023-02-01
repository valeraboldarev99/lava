<?php

Route::group([
        'prefix' => Localization::locale(),
        'middleware' => 'setLocale'], function() {

	Route::get('/', function () {
	    return view('index');
	})->name('main_page');
});

Route::group(['middleware' => ['auth', 'status']], function() {

		Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
		    ->name('ckfinder_connector');

		Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
		    ->name('ckfinder_browser');
});