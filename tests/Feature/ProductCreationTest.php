<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_create_a_product()
    {

        // try {
        //     $admin = \App\Models\Admin::factory()->create();
        //     dump($admin->toArray());
        // } catch (\Throwable $e) {
        //     dump($e->getMessage());  
        //     dump($e->getTraceAsString());
        // }

        $this->withoutExceptionHandling();
        $category = Category::factory()->create();
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')
            ->post('/admin/create-product', [
                'name' => 'Test Product',
                'description' => 'Test Description',
                'price' => 100.01,
                'stock' => 10,
                'type' => 'test', 
                'category_id' => $category->id,
                'status' => '1', 

            ]);


        $response->dumpSession();

       $response->assertStatus(200)
         ->assertJson(['success' => true]);

        $this->assertDatabaseHas('products', [
            'name'  => 'Test Product',
            'price' => 100.01,
        ]);

    }
}
