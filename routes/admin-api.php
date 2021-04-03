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
//Route::get()
// Route::get('products/{products:product_uuid}', 'ProductController@show' );
// Route::get('site-content/{SiteContent}', 'SiteContentController@show' );
Route::apiResources([
		'unit' => 'UnitController',
		'site-content' => 'SiteContentController',
		'product' => 'ProductController',
		'banner' => 'BannerController'
	]);
Route::post('/product/add-image/{id}', 'ProductController@addImage');
Route::delete('/product/{id}/delete-image/{imageId}', 'ProductController@deleteImage');
Route::apiResource('order', 'AdminOrderController')->only('index','show');
Route::apiResource('coupen', 'CoupenController');
Route::post('coupen/add-product', 'CoupenController@addProduct');
Route::post('coupen/remove-product', 'CoupenController@removeProduct');

Route::put('order/{id}/update-status', 'AdminOrderController@updateStatus');
