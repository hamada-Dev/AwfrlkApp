<?php

namespace App\Models;
use App\Scopes\NonDeleteIScope;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
