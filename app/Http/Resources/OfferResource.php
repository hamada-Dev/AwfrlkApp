<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'offer_id'    => $this->id,
            'name'        => $this->name, 
            'price'       => $this->price,
            'trips_count' => $this->trips_count,
            'offer_days'  => $this->offer_days,
            'area_id'     => $this->area_id == null ? null : $this->area->name, 
            'image'            => $this->image_path,       
        ];
    }
}
