<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->user = User::factory()->create();
    }

    public function test_admin_can_view_products_page()
    {
        $this->actingAs($this->admin);
        $response = $this->get('/admin/products');
        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
    }

    public function test_non_admin_cannot_view_products_page()
    {
        $this->actingAs($this->user);
        $response = $this->get('/admin/products');
        $response->assertStatus(403);
    }

    public function test_admin_can_create_a_product()
    {
        $this->actingAs($this->admin);
        $category = Category::factory()->create();
        $productData = [
            'name' => 'New Product',
            'description' => 'Product description',
            'price' => 99.99,
            'image' => 'image.jpg',
            'stock' => 10,
            'category_id' => $category->id,
        ];

        $response = $this->post('/admin/products', $productData);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', $productData);
    }

    public function test_admin_can_update_a_product()
    {
        $this->actingAs($this->admin);
        $product = Product::factory()->create();
        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 129.99,
            'image' => 'updated.jpg',
            'stock' => 5,
            'category_id' => $product->category_id,
        ];

        $response = $this->patch('/admin/products/' . $product->id, $updatedData);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', $updatedData);
    }

    public function test_admin_can_delete_a_product()
    {
        $this->actingAs($this->admin);
        $product = Product::factory()->create();

        $response = $this->delete('/admin/products/' . $product->id);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
