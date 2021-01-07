<?php

namespace App\Models;
use App\Scopes\NonDeleteIScope;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $guarded = [];

    public function offer(){
        return $this->hasMany(Offer::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }
       // fire global Scope where deleted_by == NULL
       protected static function boot()
       {
           parent::boot();
           static::addGlobalScope(new NonDeleteIScope);
       }
       public function getChiledren($id)
       {
           $counter=Area::where("parent_id",$id)->get();
            // $counter=0;
            // foreach (Area::all() as $area)
            // {         
            //     if($area->parent_id==$id)
            //         {
            //             ++$counter;
            //         }
            // }
            return count($counter);
    }
    public static function getCount($id)
    {
        $counts=Area::where('parent_id',$id)->count();
        return $counts;
    }
}
