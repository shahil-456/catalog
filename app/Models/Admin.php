<?php

namespace App\Models;
// namespace Database\Factories;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'about',
        'email',
        'password',
        'password_reset_token',
        'image',
        'last_login',
        'last_logout',
        'ip_address',
        'status',
        'is_admin',
        'is_online',

    ];

    protected $hidden = [
        'password',
        'password_reset_token',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_admin' => 'boolean',
        'last_login' => 'datetime',
        'last_logout' => 'datetime',
    ];

      
}
