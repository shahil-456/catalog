<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_create_a_product()
    {
        $category = Category::factory()->create();

        $productData = [
            'name'        => 'Unit Test Product',
            'description' => 'Test description',
            'price'       => 150,
            'stock'       => 20,
            'category_id' => $category->id,
            'type'        => 'test',
            'image'       => 'products/test.png',
            'status'      => 'Active',
            'added_by'    => 1,
        ];

        $product = Product::create($productData);

        $this->assertDatabaseHas('products', [
            'name'  => 'Unit Test Product',
            'price' => 150,
        ]);

        $this->assertInstanceOf(Product::class, $product);
    }
}
