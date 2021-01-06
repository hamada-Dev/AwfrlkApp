<?php

namespace App\models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderUrgency extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
