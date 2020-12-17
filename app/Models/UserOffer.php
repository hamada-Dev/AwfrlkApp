<?php

namespace App\Models;
use App\Scopes\NonDeleteIScope;
use Illuminate\Database\Eloquent\Model;

class UserOffer extends Model
{
    protected $fillable=["user_id","offer_id","decrement_trip","end_date"];
    protected $table="user_offers";
    protected $hidden=["created_at","updated_at"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Offer()
    {
        return $this->belongsTo(Offer::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }
}
