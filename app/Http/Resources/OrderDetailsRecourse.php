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
            'product_name' => $this->product->name,
            'amount'       => $this->amount,
            'price'        => $this->price,
            'order_id'     => $this->order_id,
            'created_at'   => $this->created_at->diffForHumans(),
        ];
    }
}
