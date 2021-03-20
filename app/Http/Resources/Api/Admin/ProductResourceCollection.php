<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Product;

class ProductResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    { 
       $this->collection->transform(function ( $product) {
            return (new ProductResource($product));
        });
       return parent::toArray($request);
    }
}
