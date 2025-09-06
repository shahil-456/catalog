<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;   

class Product extends Model
{
    use HasFactory; 
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'catalog_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];


    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
   

   
}
