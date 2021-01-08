<?php

namespace App\Models;

use App\Auth\Notifications\VerifyEmail;
use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyApiEmail;
use App\Scopes\NonDeleteIScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;


    protected $guarded = ['password_confirmation'];
    //    protected $fillable = [
    //        'firstName', 'email', 'password', 'group', 'image', 'provider_id','api_token'
    //    ];

    protected $appends = ['image_path', 'order_countU', 'order_countD'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NonDeleteIScope);
    }
    public function getImagePathAttribute()
    {
        return asset('uploads/users_images/' . $this->image);
    } //end of path

    public function getOrderCountUAttribute()
    {
        return $this->ordersUser->count();
    } //end of count order for user 

    public function getOrderCountDAttribute()
    {
        return $this->ordersDelivery->count();
    } //end of count order for delivery


    public function video()
    {
        return $this->hasMany(Video::class);
    }

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail); // my notification
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }


    public function ScopeAdmin($query)
    {
        return $query->where('group', 'admin');
    }
    public function ScopeEmployee($query)
    {
        return $query->where('group', 'emp');
    }
    public function ScopeDelivery($query)
    {
        return $query->where('group', 'delivery');
    }

    public function ScopeDeliveryActive($query)
    {
        return $query->where('group', 'delivery')->where('delivery_status', 1);
    }

    // start relation table 
    public function userOffer()
    {
        // return $this->belongsToMany(Offer::class, 'user_offers')->withPivot(['decrement_trip', 'end_date',]);
        return $this->belongsToMany(Offer::class, 'user_offers');
    }

    public function deliveryMoto()
    {
        return $this->hasOne(DeliveryMotocycle::class);
    }

    public function deliveryStatus()
    {
        return $this->hasMany(DeliveryStatus::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    // order relation 
    public function ordersUser()
    {
        return $this->hasMany(Order::class, 'client_id');
    }
    public function ordersDelivery()
    {
        return $this->hasMany(Order::class, 'delivery_id');
    }



    public function promocodes()
    {
        return $this->hasMany(Promocode::class);
    }

    public function Advances()
    {
        return $this->hasMany(Advance::class);
    }
    public function usersalaries()
    {
        return $this->hasMany(Usersalary::class);
    }
}
