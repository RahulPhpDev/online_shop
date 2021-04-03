<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;
use App\Enums\ResponseMessages;
class FavouriteProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'user_id' => $this->id,
            'favourite_product' => $this->favouriteProduct($this->favouriteProduct) 
        ];
    }

    private function favouriteProduct($items)
    {
         if ( $items instanceof MissingValue ) return [];
          return $items->transform( function ($data) {
              if ( ! $data ) return null;
                    return [
                        'product_id' => $data->id,
                        'name' => $data->name
                    ];
        });
    }
     /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
   public function with($request)
    {
      return [
         'result' => 1,
          'msg' => ResponseMessages::SUCCESS
      ];
    }
}
