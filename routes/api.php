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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('customers', 'StripeController@customers');
Route::get('customer/create', 'StripeController@customerCreate');
Route::get('customer/retrieve', 'StripeController@retriveCustomer');
Route::get('customer/update', 'StripeController@updateCustomer');
Route::delete('customer/delete', 'StripeController@deleteCustomer');

Route::get('customer/authorize/hold', 'StripeController@authorizeHold');
Route::get('customer/authorize/hold/capture', 'StripeController@authorizeHoldCapture');

Route::get('customer/create/payment-method', 'StripeController@createPaymentMethod');
Route::get('customer/attach/payment-method', 'StripeController@attachPaymentMethod');

Route::get('customer/create/charge', 'StripeController@createCharge');
Route::get('customer/retrieve/charge', 'StripeController@retrieveCharge');
Route::get('customer/retrieve/charges', 'StripeController@retrieveCharges');

Route::get('customer/create/payment-intent', 'StripeController@createPaymentIntent');
Route::get('customer/create/payment-intent/hold', 'StripeController@createPaymentIntentHold');
Route::get('customer/capture/payment-intent', 'StripeController@capturePaymentIntentHold');
Route::get('customer/cancel/payment-intent', 'StripeController@cancelPaymentIntentHold');
Route::get('customer/retrieve/payment-intent', 'StripeController@retrievePaymentIntent');
Route::get('customer/retrieve/payment-intents', 'StripeController@retrieveCharges');

Route::get('merchant/retrieve/balance', 'StripeController@retrieveBalance');
Route::get('merchant/retrieve/transactions', 'StripeController@retrieveTransactionHistory');
