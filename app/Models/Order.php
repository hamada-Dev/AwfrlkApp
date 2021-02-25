<?php

namespace App\Models;

use App\Scopes\NonDeleteIScope;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $appends = ['order_price', 'product_count'];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }
    public function getOrderPriceAttribute()
    {
        return $this->orderDetails->sum('price');
    } //end of order price  

    public function getProductCountAttribute()
    {
        return $this->orderDetails->count();
    } //end of order price 

   public function getCreatedAtAttribute($val)
    {
        return date('Y-m-d h:i A', strtotime($val));
    } //end of order price  

    public function area()
    {
        return $this->belongsTo(Area::class);
    }   
    
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    } 
    
    public function orderUrgency()
    {
        return $this->hasMany(OrderUrgency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    
    public function delivery()
    {
        return $this->belongsTo(User::class, 'delivery_id');
    } 
    
    public function userOffer()
    {
        return $this->belongsTo(UserOffer::class, 'offer_or_promo_id');
    }
    
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
