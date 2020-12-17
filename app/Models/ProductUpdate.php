<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUpdate extends Model
{
    protected $guarded = [];

    // Product relation
    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
