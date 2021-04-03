<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *P
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'product_id' => $this->product_id,
        'quantity' => $this->quantity,
        // 'product' => 
        ];
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
          'msg' => 'success'
      ];
    }
}
