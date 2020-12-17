<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\NonDeleteIScope;

class DeliveryMotocycle extends Model
{
    protected $table="delivery_motocycles";
  
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }
}
