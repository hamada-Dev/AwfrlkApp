<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryRecourse extends JsonResource
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
            'name'         => $this->name,
            'description'  => $this->description,
            'image'        => $this->image_path,
            'pro_count'    => $this->product_count,
            'updated_at'   => $this->updated_at->diffForHumans(),
            'next_step'    => $this->getChiledren($this->id) > 0 ? 1 : 0, // 1=> have child, 0=> have no child
            // 'products'     => ProductRecourse::collection( $this->product),
        ];
    }
}
