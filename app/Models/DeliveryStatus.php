<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryStatus extends Model
{
    protected $guarded = [];
    protected $table='delivery_statuses';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
