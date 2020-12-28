<?php

namespace App\Models;
use App\Scopes\NonDeleteIScope;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('uploads/orders_images/' . $this->image);
    } //end of path

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
