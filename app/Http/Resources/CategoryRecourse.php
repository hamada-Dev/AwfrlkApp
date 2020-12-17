<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryRecourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'name'         => $this->name,
            'description'  => $this->description,
            'image'        => $this->image_path,
            'pro_count'    => $this->product_count,
            'updated_at'   => $this->updated_at->diffForHumans(),
        ];
    }
}
