<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];

    
    public function user(){
        return $this-> belongsToMany( User::class,'user_offers')->withPivot(['decrement_trip', 'end_date',]);
        
    }   
    
    public function area(){
        return $this->belongsTo(Area::class);
    }

}
