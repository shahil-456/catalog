<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catalog;
use App\Models\Product;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catalogs = ['Electronics', 'Furniture', 'Clothing', 'Books', 'Toys'];
        $products = [ ['name' => 'iPhone 15'], ['name' => 'Samsung Galaxy S23'], ['name' => 'Sony WH-1000XM5 Headphones'], ['name' => 'Apple MacBook Air'], ['name' => 'Dell XPS 13 Laptop'], ['name' => 'Logitech MX Master 3 Mouse'], ['name' => 'Razer BlackWidow Keyboard'], ['name' => 'Canon EOS R10 Camera'], ['name' => 'Nike Air Max Shoes'], ['name' => 'Adidas Ultraboost Sneakers'], ['name' => 'Levi’s 501 Jeans'], ['name' => 'Ray-Ban Aviator Sunglasses'], ['name' => 'Casio G-Shock Watch'], ['name' => 'Sony  5'], ['name' => 'Xbox Series X'], ['name' => 'Nintendo Switch OLED'], ['name' => 'The Alchemist (Book)'], ['name' => 'Atomic Habits (Book)'], ['name' => 'Harry Potter Box Set'], ['name' => 'Kindle Paperwhite'], ['name' => 'IKEA Dining Table'], ['name' => 'IKEA Office Chair'], ['name' => 'Philips Air Fryer'], ['name' => 'Dyson V15 Vacuum'], ['name' => 'Samsung 55” 4K TV'], ['name' => 'LG Refrigerator'], ['name' => 'Bose SoundLink Speaker'], ['name' => 'GoPro HERO11'], ['name' => 'Apple iPad Pro'], ['name' => 'Fitbit Charge 6'], ];

        foreach ($catalogs as $catalogName) {
            $catalog = Catalog::create(['name' => $catalogName]);

            for ($i = 1; $i <= 5; $i++) {
                Product::create([
                    'catalog_id' => $catalog->id,
                    'name' => Arr::random($products)['name'],
                    'price' => rand(100, 200), 
                ]);
            }
        }
    }
}


