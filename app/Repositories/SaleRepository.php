<?php

namespace App\Repositories;

use App\Models\Sale;

class SaleRepository implements SaleRepositoryInterface
{
    public function all()
    {
        return Sale::with('product')->get();
    }
}
