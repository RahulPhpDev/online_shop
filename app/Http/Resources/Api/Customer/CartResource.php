<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;
class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $collection =  $this->productCollection($this->whenLoaded('cartProducts'));
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'cart_product' => $collection ,
            'cart_sum' => $collection->sum('total_price')
        ];
    }

    protected function productCollection($items)
    {

    if ( $items instanceof MissingValue ) return [];
          return $items->transform( function ($data) {
             if ( ! $data ->product) return null;
                  return [
                            'id' => $data->id,
                            'product_uuid' => $data->product->product_uuid,
                            'name' => $data->product->name,
                            'slug' => $data->product->slug,
                            'price' => $data->product->price,
                            'product_link' => "product/".$data->product->product_uuid,
                            'product_id' => $data->product->id,
                            'quantity' => $data->quantity,
                            'total_price' => $data->product->price * $data->quantity,
                        ];
           });
    }
}
