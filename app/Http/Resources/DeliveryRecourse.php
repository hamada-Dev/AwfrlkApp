<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryRecourse extends JsonResource
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
            'id'           => $this->id,
            'firstName'    => $this->name,
            'lastName'     => $this->lastName,
            'email'        => $this->email,
            'ssn'          => $this->ssn,
            'gender'       => $this->gender,
            'phone'        => $this->phone,
            'image'        => $this->image_path,
            'area_id'      => $this->area_id == null ? $this->area_id : $this->area->name,
            'user_license' => $this->deliveryMoto == null ?? $this->deliveryMoto->user_license,
            'moto_license' => $this->deliveryMoto == null ?? $this->deliveryMoto->moto_license,
            'moto_number'  => $this->deliveryMoto == null ?? $this->deliveryMoto->moto_number,
            'type'         => $this->deliveryMoto == null ?? $this->deliveryMoto->type,
            'color'        => $this->deliveryMoto == null ?? $this->deliveryMoto->color,
            'license_renew_date'  => $this->deliveryMoto == null ?? $this->deliveryMoto->license_renew_date,
            'license_expire_date' => $this->deliveryMoto == null ?? $this->deliveryMoto->license_expire_date,
            'created_at'  => $this->deliveryMoto == null ?? $this->deliveryMoto->created_at->diffForHumans(),
            'updated_at'  => $this->deliveryMoto == null ?? $this->deliveryMoto->updated_at->diffForHumans(),
        ];
    }
}
