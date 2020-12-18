<?php

namespace App\Models;

use App\Auth\Notifications\VerifyEmail;
use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyApiEmail;
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

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('uploads/users_images/' . $this->image);
    } //end of path

    
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

    // start relation table 
    public function userOffer()
    {
        return $this->belongsToMany(Offer::class, 'user_offers')->withPivot(['decrement_trip', 'end_date',]);
    }

    public function deliveryMoto()
    {
        return $this->hasOne(DeliveryMotocycle::class);
    }

    public function deliveryStatus()
    {
        return $this->hasMany(DeliveryStatusy::class);
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
}
