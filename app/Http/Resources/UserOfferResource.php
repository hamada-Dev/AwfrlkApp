<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserOfferResource extends JsonResource
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
            'decrement_trip'   => $this->decrement_trip,
            'price'            => $this->price,
            'area'             => $this->offer->area->name,
        ];
    }
}
