<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActionLog extends Model
{
    protected $table = 'user_action_log';

    protected $fillable = [
        'user_id',
        'description',
        'created_at',
    ];

    public $timestamps = false;
}
