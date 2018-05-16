<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * PRODUCTS
 */
Route::get('/products/list', 'Products\ProductsController@list');
Route::get('/products/slug/{slug}', 'Products\ProductsController@slug');
Route::get('/products/{product}/relateds', 'Products\ProductsController@related');
Route::get('/products/categories/list', 'Products\CategoriesController@list');

/**
 * FORMS
 */
Route::post('/site/contact', 'ContactFormController@send');

/**
 * NEWSLETTER
 */
Route::group(['namespace' => 'Newsletter'], function () {
    Route::post('/newsletter/signin', 'LeadController@signin');
    Route::get('/newsletter/signout/{token}', 'LeadController@signout');
});

/**
 * ADDRESSES
 */
Route::group(['namespace' => 'Addresses', 'prefix' => 'addresses'], function () {
    Route::get('states', 'AddressesController@states');
    Route::get('states/{state}/cities', 'AddressesController@cities');
});

/**
 * REGISTER
 */
Route::post('/register', 'CustomersController@register');

/**
 * CUSTOMER
 */
Route::get('/customers/confirmation/{token}', 'CustomersController@confirmation');
Route::get('/customers/forgot/password', 'CustomersController@forgotPassword');
Route::get('/customers/reset/password/{token}', 'CustomersController@resetPassword');

/**
 * PAGSEGURO
 */
Route::post('/payments/pagseguro/webhook', 'Payments\PagSeguroController@webhook');

/**
 * INSTAGRAM
 */
Route::get('/integration/instagram/recent', 'Instagram\InstagramController@recent');
