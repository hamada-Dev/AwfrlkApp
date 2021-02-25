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
    
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
