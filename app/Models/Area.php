<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $guarded = [];

    public function offer(){
        return $this->hasMany(Offer::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }
}
