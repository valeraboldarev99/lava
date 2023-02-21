<?php

Route::group([
        'prefix' => Localization::locale(),
        'middleware' => 'setLocale'], function() {

	Route::get('/', function () {
	    return view('index');
	})->name('main_page');
});