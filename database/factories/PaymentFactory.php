<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payment_id' => $this->faker->uuid,
            'amount' => $this->faker->randomFloat(2, 50, 2000),
            'status' => $this->faker->randomElement(['pending', 'succeeded', 'failed']),
            'method' => $this->faker->randomElement(['credit_card', 'paypal', 'stripe']),
            'order_id' => Order::factory(),
        ];
    }
}
