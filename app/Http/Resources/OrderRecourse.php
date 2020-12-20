<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderRecourse extends JsonResource
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
            'created_at'     => $this->created_at,
            'arrival_date'   => $this->arrival_date,
            'order_price'    => $this->order_price,
            'delivery_price' => $this->delivery_price,
            'order_pro_cnt'  => $this->product_count,
            'products'       => OrderDetailsRecourse::collection( $this->orderDetails),
        ];
    }
}
