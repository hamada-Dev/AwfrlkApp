<?php

namespace App\Models;
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
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }
}
