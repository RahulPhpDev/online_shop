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
Route::middleware('auth:api')->group( function() {
    Route::apiResource('notifcation', 'Auth\NotificationContoller')->only(['index', 'update', 'destroy']);
    Route::get('notifcation/unread', 'Auth\NotificationContoller@unread');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('/otp', 'Auth\LoginController@otp')->name('login.otp');
    Route::post('/login', 'Auth\LoginController@login')->name('login.api');
    Route::post('/register','Auth\RegisterController@register')->name('register.api');
    // Route::get('/site-content/{id?}', 'Guest\GuestController@siteContent');
    // Route::get('/banner/{id?}', 'Guest\GuestController@banner');
    // Route::get('/product/{id?}', 'Guest\GuestController@product');

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
        Route::get('/home', 'HomeController@index');
        Route::get('/pages/{id?}', 'HomeController@siteContent');
        Route::post('/pages', 'HomeController@show');
        Route::get('/banner/{id?}', 'HomeController@banner');
        Route::post('/banner', 'HomeController@showBanner');
        Route::apiResource('favourite-product', 'FavouriteProductController')->only('index', 'store', 'destroy');

        Route::get('/product/{id?}', 'HomeController@product');
        Route::apiResource('/cart','CartController')->only('index', 'store');
        Route::delete('cart/{cartId}/cart-product/{productId}/remove', 
                'CartController@removeProductFromCart')->name('cart.remove.product');
        Route::apiResource('address','AddressController');
        Route::apiResource('order','OrderController');
    });
});


