<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'          => $this->id,
            'firstName'   => $this->name,
            'lastName'    => $this->lastName,
            'email'       => $this->email,
            'password'    => null,
            'c_password'  => null,
            'ssn'         => $this->ssn,
            'gender'      => $this->gender,
            'phone'       => $this->phone,
            'adress'      => $this->adress,
            'image'       => $this->image_path,
            'area_id'     => $this->area_id == null ? $this->area_id : $this->area->name,
            'areaId'      => $this->area_id,
        ];
    }
}
