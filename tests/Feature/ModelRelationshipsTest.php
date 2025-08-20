<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_belongs_to_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    public function test_category_has_many_products()
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertCount(3, $category->products);
        $this->assertInstanceOf(Product::class, $category->products->first());
    }

    public function test_user_has_many_orders()
    {
        $user = User::factory()->create();
        Order::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->orders);
        $this->assertInstanceOf(Order::class, $user->orders->first());
    }

    public function test_order_belongs_to_user()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($user->id, $order->user->id);
    }

    public function test_order_has_many_order_items()
    {
        $order = Order::factory()->create();
        OrderItem::factory()->count(4)->create(['order_id' => $order->id]);

        $this->assertCount(4, $order->orderItems);
        $this->assertInstanceOf(OrderItem::class, $order->orderItems->first());
    }

    public function test_order_item_belongs_to_order_and_product()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $orderItem = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
        ]);

        $this->assertInstanceOf(Order::class, $orderItem->order);
        $this->assertEquals($order->id, $orderItem->order->id);
        $this->assertInstanceOf(Product::class, $orderItem->product);
        $this->assertEquals($product->id, $orderItem->product->id);
    }

    public function test_cart_belongs_to_user_and_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertInstanceOf(User::class, $cart->user);
        $this->assertEquals($user->id, $cart->user->id);
        $this->assertInstanceOf(Product::class, $cart->product);
        $this->assertEquals($product->id, $cart->product->id);
    }

    public function test_payment_belongs_to_order()
    {
        $order = Order::factory()->create();
        $payment = Payment::factory()->create(['order_id' => $order->id]);

        $this->assertInstanceOf(Order::class, $payment->order);
        $this->assertEquals($order->id, $payment->order->id);
    }
}
