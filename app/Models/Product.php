<?php

namespace App\Models;

use App\Scopes\NonDeleteIScope;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    // fire global Scope where deleted_by == NULL
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('uploads/products_images/' . $this->image);
    } //end of path

    // category Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ProductUpdate()
    {
        return $this->hasMany(ProductUpdate::class);
    }
    
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
