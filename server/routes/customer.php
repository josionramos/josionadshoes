<?php

Route::group(['prefix' => 'customers/me'], function () {
    /**
     * PROFILE
     */
    Route::get('/', 'CustomersController@me');
    Route::put('/', 'CustomersController@profile');

    /**
     * ORDERS
     */
    Route::group(['namespace' => 'Orders', 'prefix' => 'orders'], function () {
        Route::get('/', 'CustomersController@index');
        Route::post('/', 'CustomersController@store');
        Route::get('/{order}', 'CustomersController@show');
        Route::post('/{order}/add', 'CustomersController@add');
        Route::put('/{order}/items/{item}', 'CustomersController@update');
        Route::delete('/{order}/items/{item}', 'CustomersController@remove');

        Route::post('/{order}/shipping', 'ShippingsController@calc');
    });

    /**
     * ADDRESSES
     */
    Route::group(['namespace' => 'Addresses'], function () {
        Route::apiResource('addresses', 'CustomersController');
    });
});

/**
 * PAGSEGURO
 */
Route::group(['prefix' => 'payments/pagseguro', 'namespace' => 'Payments'], function () {
    Route::post('/', 'PagSeguroController@process');
    Route::get('/session', 'PagSeguroController@session');
});
