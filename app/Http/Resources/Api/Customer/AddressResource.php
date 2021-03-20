<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'house_no' => $this->house_no,
            'street' => $this->street,
            'state' => $this->state,
            'district' => $this->district,
            'pin_code' => $this->pin_code,
            'landmark' => $this->landmark,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'user' => $this->userAddress( $this->whenLoaded('user'))
        ];
    }

    private function userAddress($items)
    {
        if ( $items instanceof MissingValue ) return [];
          return $items->transform( function ($data) {
              return [
                 'id' => $data->id,
                'name' => $data->name
              ];
         });
    }
}
