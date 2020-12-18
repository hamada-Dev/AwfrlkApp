<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRecourse extends JsonResource
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
            'name'         =>  $this->name,
            'description'  =>  $this->description,
            'unit'         =>  $this->unit,
            'price'        =>  $this->price,
            'image'        =>  $this->image_path,
            'updated_at'   =>  $this->updated_at->diffForHumans(),
        ];
    }

    public function with($request)
    {
        return [
            'category_name'    => $this->category->name,
        ];
    }
}
