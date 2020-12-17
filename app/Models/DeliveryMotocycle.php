<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\NonDeleteIScope;

class DeliveryMotocycle extends Model
{
    protected $table="delivery_motocycles";
    protected $fillable=[ 'user_license' ,'moto_license' ,'moto_number' ,'license_renew_date','license_expire_date','type' ,'color','user_id','deleted_by' ];
    protected $hidden=["created_at",'updated_at'];

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
