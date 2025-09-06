<?php

namespace App\Repositories;

use App\Models\Catalog;

class CatalogRepository implements CatalogRepositoryInterface
{
    public function all()
    {
        return Catalog::all();
    }
}

