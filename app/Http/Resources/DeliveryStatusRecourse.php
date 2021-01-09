<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryStatusRecourse extends JsonResource
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
            'satus'         => ($this->status ==  0  ?  'Busy' : ($this->status ==  1  ?  'Active' : 'Not Active')),
            'created_at'       => date('d-M-Y H:i A', strtotime($this->created_at)),
            'updated_at'       => date('d-M-Y H:i A', strtotime($this->updated_at)),
        ];
    }
}
