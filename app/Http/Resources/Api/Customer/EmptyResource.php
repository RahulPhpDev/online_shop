<?php

namespace App\Http\Resources\Api\Customer;

use App\Enums\ResponseMessages;
use Illuminate\Http\Resources\Json\JsonResource;

class EmptyResource extends JsonResource
{

  public function __construct()
  {
    
  }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [];
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
          'msg' => ResponseMessages::EMPTY
      ];
    }
}
