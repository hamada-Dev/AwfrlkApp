<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\NonDeleteIScope;
class Offer extends Model
{
    protected $fillable = ['price','trips_count','offer_days','area_id','avilable','deleted_by'];
    protected $hidden=["created_at",'updated_at'];
    
    public function user(){
        return $this-> belongsToMany( User::class,'user_offers')->withPivot(['decrement_trip', 'end_date',]);
        
    }   
    
    public function area(){
        return $this->belongsTo(Area::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }
}
