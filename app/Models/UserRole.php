<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_name',
        'role_access',
        'role_resources',
        'created_at',
    ];

    public $timestamps = false;

     public function users()
    {
        return $this->hasMany(User::class, 'user_role_id', 'role_id');
    }
}
