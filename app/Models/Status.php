<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'type',
        'style',
    ];

    public $timestamps = false;


   

}
