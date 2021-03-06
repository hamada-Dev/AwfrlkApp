<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDeliveryRecourse extends JsonResource
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
            'user_name'       => $this->user->name,
            'user_date'       => new UserResource( $this->user),
            'created_at'      => $this->created_at,
            // 'created_at'      => $this->created_at->diffForHumans(),
            'end_shoping_date'=> $this->end_shoping_date,
            'arrival_date'    => $this->arrival_date,
            'order_price'     => $this->order_price,
            'price_type'      => $this->type,
            'delivery_price'  => $this->delivery_price,
            'order_pro_cnt'   => $this->product_count,
            'products'        => OrderDetailsRecourse::collection( $this->orderDetails),
        ];

    }
}
