<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryStatus extends Model
{    
    
    protected $table='delivery_statuses';

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
