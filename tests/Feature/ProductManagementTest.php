<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_a_list_of_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
        $response->assertViewHas('products');
    }

    public function test_it_displays_a_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->get('/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertViewIs('products.show');
        $response->assertViewHas('product');
    }

    public function test_it_displays_a_list_of_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->get('/categories');

        $response->assertStatus(200);
        $response->assertViewIs('categories.index');
        $response->assertViewHas('categories');
    }

    public function test_it_displays_products_in_a_category()
    {
        $category = Category::factory()->create();
        Product::factory()->count(2)->create(['category_id' => $category->id]);

        $response = $this->get('/categories/' . $category->id);

        $response->assertStatus(200);
        $response->assertViewIs('categories.show');
        $response->assertViewHas('category');
        $response->assertViewHas('products');
    }
}
