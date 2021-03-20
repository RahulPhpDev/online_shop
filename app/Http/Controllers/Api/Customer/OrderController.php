<?php

namespace App\Http\Controllers\Api\Customer;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\OrderCreatedNotification;
use App\PipeLines\RemoveProductFromCart;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function index()
    {
       $order = Order::user()->with('product')->latest()->paginate(PaginationEnum::CommonPagination);
       return $order;

    }

    private function removeProductFromCart($request)
    {
        $pipes = [
            RemoveProductFromCart::class,
        ];        
         app(Pipeline::class)
                ->send($request->all())
                ->through($pipes)
                ->then( function ($res)  {
                   return $res; 
                });
    }


    public function store(OrderRequest $request)
    {
        $this->removeProductFromCart($request);
         DB::beginTransaction();
         $order = Order::create(
                $request->except('product_id', 'quantity')
         );  
         $productWithQuanityAndPrice =  $this->mapProductWithQuantity($request->only('product_id', 'quantity') );
         $order->product()->sync($productWithQuanityAndPrice);
         DB::commit();
     
      $adminsAndCurrentUser = \App\User::admins()->orWhere('id', \Auth::id())->get();
       Notification::send($adminsAndCurrentUser, new OrderCreatedNotification(
            $order->loadMissing('product')
       ));
       // need to modify here need to send some other record
         return $order;
    }

    private function mapProductWithQuantity($payload)
    {
        $productIdArr = $payload['product_id'];
        $key = array_keys( $productIdArr);
        $productIds =  array_values($productIdArr);
        $productPrices =   Product::whereIn('id' ,$productIds)->select('price', 'id')->pluck('price', 'id');
        $payloadCollection = collect( $key )->map( function ( $key, $item)
                                     use($payload,  $productPrices, $productIdArr) {
                                $productId =  $productIdArr[$key];
                                    return [
                                            'product_id' => $productId,
                                            'quantity' =>  $payload['quantity'][$key] ?? 1,
                                            'price' => $productPrices[$productId]
                                    ];
       });
     return $payloadCollection->toArray();
    }
}
