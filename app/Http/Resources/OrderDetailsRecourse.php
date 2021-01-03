<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsRecourse extends JsonResource
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
            'product_name' => $this->product == null ? Null : $this->product->name,
            'amount'       => $this->amount,
            'price'        => $this->price,
            'description'  => $this->description,
            'image'        => $this->image == null ? null : $this->image_path ,
            'product_home' => $this->product_home,
            'created_at'   => $this->created_at->diffForHumans(),
        ];
    }
}
