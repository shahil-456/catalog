<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailNotificationData extends Model
{
    protected $table = 'email_notification_data';

    protected $fillable = [
        'user_id',
        'email',
        'name',
        'subject',
        'body',
        'cc_mail',
        'created_at',
        'updated_at',
        'status',
    ];

    public $timestamps = false;

}
