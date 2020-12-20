<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyOfferResource extends JsonResource
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
            'name'              => $this->name,
            'price'             => $this->price,
            'trips_count'       => $this->trips_count,
            'offer_days'        => $this->offer_days,
            'area_id'           => $this->area->name,

            'decrement_trip'   => $this->pivot->decrement_trip,
            'end_date'          => $this->pivot->end_date,
        ];
    }
}
