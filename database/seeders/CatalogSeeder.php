<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catalog;

class CatalogSeeder extends Seeder
{
        public function run(): void
    {
        $catalogs = ['Electronics', 'Furniture', 'Clothing', 'Books', 'Toys'];

        foreach ($catalogs as $name) {
            Catalog::create(['name' => $name]);
        }
    }

    
}

