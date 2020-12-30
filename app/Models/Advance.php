<?php

namespace App\Models;
use App\Scopes\NonDeleteIScope;

use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    protected $guarded=[];
    
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
