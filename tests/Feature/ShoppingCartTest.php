<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_their_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/cart');

        $response->assertStatus(200);
        $response->assertViewIs('cart.index');
    }

    public function test_unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->get('/cart');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_add_a_product_to_their_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create();

        $response = $this->post('/cart', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    public function test_authenticated_user_can_update_cart_item_quantity()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create();
        $cartItem = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->patch('/cart/' . $cartItem->id, [
            'quantity' => 3,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('carts', [
            'id' => $cartItem->id,
            'quantity' => 3,
        ]);
    }

    public function test_authenticated_user_can_remove_a_product_from_their_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create();
        $cartItem = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->delete('/cart/' . $cartItem->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('carts', [
            'id' => $cartItem->id,
        ]);
    }
}
