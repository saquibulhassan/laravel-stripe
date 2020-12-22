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

Route::get('customer/create', 'StripeController@customerCreate');
Route::get('customer/create/charge', 'StripeController@createCharge');
Route::get('customer/retrieve/charge', 'StripeController@retrieveCharge');
Route::get('customer/retrieve/charges', 'StripeController@retrieveCharges');
Route::get('customer/authorize/hold', 'StripeController@authorizeHold');
Route::get('customer/authorize/hold/capture', 'StripeController@authorizeHoldCapture');


Route::get('merchant/retrieve/balance', 'StripeController@retrieveBalance');
Route::get('merchant/retrieve/transactions', 'StripeController@retrieveTransactionHistory');
