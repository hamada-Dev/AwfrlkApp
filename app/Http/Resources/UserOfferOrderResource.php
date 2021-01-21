<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserOfferOrderResource extends JsonResource
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
            'offer'            => $this->offer->name,
            'remaine_trip'     => $this->decrement_trip,
            'price'            => $this->price,
            'area'             => $this->offer->area->name,
            'image'            => $this->image_path,
            'created_at'       => date('d-M-Y H:i A', strtotime($this->created_at)),
            'end_date'         => date('d-M-Y H:i A', strtotime($this->end_date)),

            'order'            => OrderUserRecourse::collection($this->order),
        ];
    }
}
