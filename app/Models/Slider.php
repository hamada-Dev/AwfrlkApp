<?php

namespace App\models;

use App\Scopes\NonDeleteIScope;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $guarded = [];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('uploads/sliders_images/' . $this->image);
    } //end of image path 

    // fire global Scope where deleted_by == NULL
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }
}
