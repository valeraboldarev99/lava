<?php

use Illuminate\Support\Facades\Route;

Route::group([
        'prefix' => Localization::locale(),
        'middleware' => 'setLocale'], function() {

    $namespace = 'App\Modules\Products\Http\Controllers';

    Route::group(['namespace' => $namespace, 'middleware' => ['web']], function() {
    // admin
        Route::group(['middleware' => ['auth', 'status'],
                'prefix' => config('cms.url.admin_prefix'),
                'as' => config('cms.admin_prefix'),
                'namespace' => 'Admin'], function() {

// products
            Route::delete('/products/deleteFile/{id}/{field}', 'IndexController@deleteFile')->name('products.deleteFile');              //delete single file or image
            Route::delete('/products/deleteMultiFiles/{entity_id}/{field}/{file_id}', 'IndexController@deleteMultiFiles')->name('products.deleteMultiFiles');   //delete multi files
            Route::post('/products/multi_uploader', 'IndexController@multiUploader')->name('products.multiUploader');                                            //multi uploading images
            Route::post('/products/change_file', 'IndexController@changeFile')->name('products.changeFile');                                            //changeFile
            Route::get('/products/download_file/{id}/{field}', 'IndexController@downloadFile')->name('products.downloadFile');                                            //downloadFile
            Route::resource('/products', 'IndexController')->names('products');
            Route::post('/products/position/{id}/{direction}', 'IndexController@position')->name('products.position');
            Route::post('/products/file-position', 'IndexController@positionFile')->name('products.positionFiles');
            Route::post('/products/image-position', 'IndexController@positionImage')->name('products.positionImages');
// products_categories
            Route::delete('/products_categories/deleteFile/{id}/{field}', 'ProductsCategoriesController@deleteFile')->name('products_categories.deleteFile');              //delete single file or image
            Route::get('/products_categories/download_file/{id}/{field}', 'ProductsCategoriesController@downloadFile')->name('products_categories.downloadFile');                                            //downloadFile
            Route::post('/products_categories/position/{id}/{direction}', 'ProductsCategoriesController@position')->name('products_categories.position');

            Route::resource('/products_categories', 'ProductsCategoriesController')->names('products_categories');
        });

    //user
        // Route::get('products', 'IndexController@index')->name('products.index');
        Route::get('products/{parent_slug}/{slug}', 'IndexController@categories')->name('products.categories');
        Route::get('catalog/{slug}', 'IndexController@categories')->name('products.parent_categories');

        Route::get('/products/{id}', 'IndexController@show')->name('products.show');
     });
 });
