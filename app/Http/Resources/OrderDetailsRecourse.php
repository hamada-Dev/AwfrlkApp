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
            'category_id'  => $this->product->category_id ??  0, //if this has no cat this mean this is phar or home
            'created_at'   => $this->created_at->diffForHumans(),
            
            // this is i make for save to and not want to edit every event to add order 
            'order_type'   => $this->product_id != null ? 'product' : ($this->product_home != null ? 'home' :'pharmacy'),
            'order_id'     => $this->order_id,

        ];
    }
}
