<?php

namespace App\Models;

use App\Scopes\AvilableScope;
use App\Scopes\NonDeleteIScope;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];

    
    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('uploads/offers_images/' . $this->image);
    } //end of path


    public function user()
    {
        return $this->belongsToMany(User::class, 'user_offers')->withPivot(['decrement_trip', 'end_date',]);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
        static::addGlobalScope(new AvilableScope);
    }
}
