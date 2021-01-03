<?php

namespace App\Models;
use App\Scopes\NonDeleteIScope;

use Illuminate\Database\Eloquent\Model;

class Usersalary extends Model
{
    protected $guarded = [];
    protected $table="usersalaries";

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
