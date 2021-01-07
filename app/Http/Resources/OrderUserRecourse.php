<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Null_;

class OrderUserRecourse extends JsonResource
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
            'order_id'       => $this->id,
            'created_at'     => $this->created_at,
            'arrival_date'   => $this->arrival_date,
            'order_price'    => $this->order_price,
            'delivery_price' => $this->delivery_price,
            'order_pro_cnt'  => $this->product_count,
            'area'           => $this->area_id == null ? null : $this->area->name,
            'address'        => auth()->user()->adress,
            'area_id_from'   => $this->area_id_from == null ? null : $this->area->name,
            'adress_from'    => $this->adress_from,
            'products'       => OrderDetailsRecourse::collection( $this->orderDetails),
            'delivery'       => [
                'delivery_name'  => $this->delivery_id == Null ? 'Not confirmed from any delivery' : $this->delivery->name . ' ' . $this->delivery->last_name ,
                'delivery_phone' => $this->delivery_id == Null ? 'Not confirmed from any delivery' : $this->delivery->phone  ,
            ],
            'type'           => $this->type == 0 ? 'order' : ($this->type == 1 ? 'offer' : 'promo'),
        ];
    }
}
