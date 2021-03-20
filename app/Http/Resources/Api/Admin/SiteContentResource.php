<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteContentResource extends JsonResource
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
               'title' => $this->title, 
               'slug' => $this->slug, 
               'description' => $this->description, 
               'visible' => $this->visible
        ];
    }
}