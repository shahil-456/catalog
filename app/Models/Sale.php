<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['product_id','product_name'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();

    }
}




