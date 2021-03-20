<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\CreateCartRequest;
use App\Http\Resources\Api\Customer\CartResource;
use App\Http\Resources\Api\Customer\CartResourceCollection;
use App\Models\Cart;
use App\Models\cartProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
     public function index()
     {
     	$carts = Cart::with('cartProducts')->first();
 		return new CartResource($carts);
     }

     public function store(CreateCartRequest $request)
     {
     	$cart = Cart::firstOrCreate( 
     			['user_id' => Auth::id()]
     		);
     	$cart->products()->sync([
     				 $request->product_id =>
     				 ['quantity' => $request->quantity],
				], false);
     	return new CartResource($cart->loadMissing('cartProducts'));
     }


     public function removeProductFromCart($cartId, $productId)
     {
      	$cart = Cart::with('products')->findOrFail($cartId);
     	$cart->products()->detach($productId);
     	return new CartResource($cart->loadMissing('cartProducts')); 
     }


     public function destroy()
     {

     }
}
