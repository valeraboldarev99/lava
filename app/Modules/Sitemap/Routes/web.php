<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\Sitemap\Http\Controllers\\';

Route::get('robots.txt', $namespace . 'IndexController@robots')->name('robots.txt');
Route::get('sitemap.xml', $namespace . 'IndexController@sitemap')->name('sitemap.xml');
