<?php

namespace App\Models;

use App\Scopes\ConfirmedOffer;
use App\Scopes\NonDeleteIScope;
use Illuminate\Database\Eloquent\Model;

class UserOffer extends Model
{
    protected $guarded = [];
    protected $table="user_offers";
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Offer()
    {
        return $this->belongsTo(Offer::class);
    }
    
    public function order()
    {
        return $this->hasMany(Order::class, 'offer_or_promo_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
        static::addGlobalScope(new ConfirmedOffer);//this global scope for get offer which confirmed from delivery
    }
}
