<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_redirects_to_stripe_checkout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->post('/payment');

        $response->assertStatus(302);
        $this->assertStringContainsString('https://checkout.stripe.com', $response->getTargetUrl());
    }

    public function test_it_handles_payment_cancellation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/payment/cancel');

        $response->assertRedirect('/cart');
        $response->assertSessionHas('error', 'Payment was cancelled.');
    }
}
