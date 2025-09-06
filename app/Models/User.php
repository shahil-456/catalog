<?php

// namespace App\Models;




namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'first_name',
        'last_name',
        'profile_photo',
        'password',
        'status',
        'active',
        'twofa_enabled',
        'google_2fa_secret',
        'popup_seen',
        'qr_code_url',
        'ip_address',
    ];

    protected $hidden = [
        'password',
    ];

    

   
      public function notifies()
    {
        return $this->hasMany(Notification::class,'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    
    





}

