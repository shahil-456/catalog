<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

   protected $fillable = [
        'id',
        'type',
        'user_id',
        'message',
        'status',
        'read_at',
    ];

    // 🔁 Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
