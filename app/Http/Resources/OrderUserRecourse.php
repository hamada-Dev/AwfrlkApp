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
            'created_at'     => date('Y-m-d H:i:s ', strtotime($this->created_at)),
            'arrival_date'   => $this->arrival_date,
            'order_price'    => $this->order_price + $this->delivery_price, 
            'delivery_price' => $this->delivery_price,
            'order_pro_cnt'  => $this->product_count,
            'area'           => $this->area_id == null ? null : $this->area->name,
            'address'        => auth()->user()->adress,
            'area_id_from'   => $this->area_id_from == null ? null : $this->area->name,
            'adress_from'    => $this->adress_from,
            'price_type'      => $this->type, // return 0 => usual 1 => offer, 2 => promo
            'order_type'     => $this->orderDetails[0]->product_id != null ? 'product' : ($this->area_id_from != null ? 'home' :'pharmacy'),
            'end_order'      => $this->arrival_date != null ? 0 : ($this->delivery_id == null ? 1 : 2), // 0 => order ended 1=> no delivery take it 2 => under implement
            'products'       => OrderDetailsRecourse::collection( $this->orderDetails),
            'delivery'       => [
                'delivery_name'  => $this->delivery_id == Null ? 'Not confirmed from any delivery' : $this->delivery->name . ' ' . $this->delivery->last_name ,
                'delivery_phone' => $this->delivery_id == Null ? 'Not confirmed from any delivery' : $this->delivery->phone  ,
            ],
            'type'           => $this->type == 0 ? 'order' : ($this->type == 1 ? 'offer' : 'promo'),
            'Urgency'        => $this->orderUrgency->count() > 0  ? date('Y-m-d H:i:s ', strtotime($this->orderUrgency->last()->created_at)) : date('Y-m-d H:i:s ', strtotime($this->created_at)),
        ];
    }
}
