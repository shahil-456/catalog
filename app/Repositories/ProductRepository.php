<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function allByCatalog($catalogId)
    {
        return Product::where('catalog_id', $catalogId)->get();
    }
}
