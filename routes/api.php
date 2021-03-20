<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:api')->post('/logout','Auth\LoginController@logout')->name('logout.api');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('/login', 'Auth\LoginController@login')->name('login.api');
    Route::post('/register','Auth\RegisterController@register')->name('register.api');
    Route::get('/site-content/{id?}', 'Guest\GuestController@siteContent');
    Route::get('/banner/{id?}', 'Guest\GuestController@banner');
    Route::get('/product/{id?}', 'Guest\GuestController@product');

    Route::get('/testing/{str?}', 'Guest\GuestController@testing');

    Route::group([
        'as' => 'customer.',
    	'middleware' => [
    		'api',
    		'auth:api',
    		'api.customer'
    	],
    	'prefix' => 'customer',
    	'namespace' => 'Customer',
    ], function ()  {
            Route::apiResource('/cart','CartController')->only('index', 'store');
            Route::delete('cart/{cartId}/cart-product/{productId}/remove', 
                    'CartController@removeProductFromCart')->name('cart.remove.product');
            Route::apiResource('address','AddressController');
            Route::apiResource('order','OrderController');
    });
});


