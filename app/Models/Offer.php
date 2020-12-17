<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\NonDeleteIScope;
class Offer extends Model
{
    protected $guarded = [];

    public function user(){
        return $this-> belongsToMany( User::class,'user_offers')->withPivot(['decrement_trip', 'end_date',]);
        
    }   
    
    public function area(){
        return $this->belongsTo(Area::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }
}
