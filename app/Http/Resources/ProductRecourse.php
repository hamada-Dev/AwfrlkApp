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
            'id'           =>  $this->id,
            'name'         =>  $this->name,
            'description'  =>  $this->description,
            'unit'         =>  $this->unit,
            'price'        =>  $this->price,
            'image'        =>  $this->image_path,
            'updated_at'   =>  $this->updated_at->diffForHumans(),
            'category'     =>  $this->category ?  $this->category->name : '',

        ];
    }

    public function with($request)
    {
        return [
            'category_name'    => $this->category->name,
        ];
    }
}
