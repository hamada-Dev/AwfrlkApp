<?php

namespace App\Models;

use App\Scopes\NonDeleteIScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    // fire global Scope where deleted_by == NULL
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }

    protected $appends = ['image_path', 'product_count'];

    public function getImagePathAttribute()
    {
        return asset('uploads/categories_images/' . $this->image);
    } //end of image path 
    
    public function getProductCountAttribute()
    {
        return $this->product->count();
    } //end of product count in this category 

    public function getChiledren($id)
    {
        return $this->where("parent_id", $id)->count();
    }


    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
