<?php 

namespace App\PipeLines;
use App\Interfaces\Pipe;
use Closure;
use App\Models\Cart;

class RemoveProductFromCart implements Pipe
{
  public function handle($content, Closure $next)
	{
		$product_ids = array_values($content['product_id']);
	    $cart =     Cart::with(['cartProducts' =>  function ($query) use ($product_ids ) {
						 $query->whereIn('product_id', $product_ids)->without('product')->delete();
						}]
			)->get();
		 return  $next($content);
	}
}  