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
            $this->deliveryStatus,
            // 'status0' => date('i:s', strtotime($this->deliveryStatus[1]->created_at) - strtotime($this->deliveryStatus[0]->created_at)),
            // 'status1' => $this->deliveryStatus[1]->created_at,
            // 'status2' => $this->deliveryStatus[2]->created_at,
        ];
    }
}
