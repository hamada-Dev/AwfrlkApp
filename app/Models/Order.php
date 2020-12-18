<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $appends = ['order_price', 'product_count'];

    public function getOrderPriceAttribute()
    {
        return $this->orderDetails->sum('price');
    } //end of order price  

    public function getProductCountAttribute()
    {
        return $this->orderDetails->count();
    } //end of order price  

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
