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
            'firstName'   => $this->firstName,
            'lastName'    => $this->lastName,
            'email'       => $this->email,
            'ssn'         => $this->ssn,
            'gender'      => $this->gender,
            'phone'       => $this->phone,
            'image'       => $this->image_path,
            'area_id'     => $this->area->name,
        ];
    }
}
