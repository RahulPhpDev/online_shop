<?php

namespace App\Http\Resources\Api\Admin;

use App\Http\Resources\Api\Admin\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_uuid' => $this->product_uuid,
            'name'  => $this->name,
            'slug'  => $this->slug,
            'description'  => $this->description,
            'unit_id'  => $this->unit_id,
            'unit' => new UnitResource($this->whenLoaded('unit')),
            'inventory' => new InventoryResource($this->whenLoaded('inventory')),
            'imageable' => new ImageResource($this->whenLoaded('imageable')),
            'is_popular'  => $this->is_popular,
            'price'  => $this->price,
            'available'  => $this->available,
            'feature' => $this->feature
        ];
    }
}
