<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_the_checkout_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/checkout');

        $response->assertStatus(200);
        $response->assertViewIs('checkout.index');
    }

    public function test_unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->get('/checkout');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_place_an_order()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product1 = Product::factory()->create(['price' => 10]);
        $product2 = Product::factory()->create(['price' => 20]);

        Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product1->id,
            'quantity' => 2,
        ]);
        Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product2->id,
            'quantity' => 1,
        ]);

        $response = $this->post('/checkout');

        $response->assertRedirect('/orders');
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'order_total' => 40,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product1->id,
            'quantity' => 2,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product2->id,
            'quantity' => 1,
        ]);
        $this->assertDatabaseCount('carts', 0);
    }
}
