<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\ResponseMessages;
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
          'msg' => ResponseMessages::PAGES
      ];
    }
}
