<?php

Route::get('/users/me', 'UsersController@me');

/**
 * PRODUCTS
 */
Route::group(['namespace' => 'Products'], function () {
    Route::group(['prefix' => 'products'], function () {
        // Categories
        Route::apiResource('categories', 'CategoriesController');

        // Medias
        Route::post('/{product}/cover', 'MediaController@cover');
        Route::post('/{product}/media', 'MediaController@store');
        Route::delete('/{product}/media', 'MediaController@destroy');

        // Variant types
        Route::get('/variants/types', 'VariantTypesController@index');
        Route::delete('/variants/types', 'VariantTypesController@destroy');

        // Variants
        Route::apiResource('{product}/variants', 'VariantsController');
    });

    // Products
    Route::apiResource('products', 'ProductsController');
});

/**
 * MEDIAS
 */
Route::post('/galleries/{gallery}/media', 'MediaController@upload');


/**
 * ORDERS
 */
Route::group(['namespace' => 'Orders', 'prefix' => 'orders'], function () {
    Route::get('/', 'OrdersController@index');
    Route::get('/{order}', 'OrdersController@show');
    Route::get('/{order}/items', 'ItemsController@index');

    // Shipping
    Route::put('/{order}/shipping/tracker', 'ShippingsController@tracker');
});

/**
 * USERS
 */
Route::get('/users', 'UsersController@index');

/**
 * NEWSLETTER
 */
Route::get('/newsletter/leads', 'Newsletter\LeadController@index');
Route::get('/newsletter/leads/export', 'Newsletter\LeadController@export');

/**
 * CUSTOMERS
 */
Route::get('/customers', 'CustomersController@index');
