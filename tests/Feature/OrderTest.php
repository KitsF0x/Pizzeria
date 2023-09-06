<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Pizza;
use App\Models\User;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\PizzasSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function user_with_customer_role_can_order_pizza(): void
    {
        $this->seed(PizzasSeeder::class);
        $this->seed(CustomerSeeder::class);

        $response = $this->post(route('order.store'), [
            "user_id" => User::first(),
            "pizza_id" => Pizza::first(),
        ]);

        $response->assertOk();
        $this->assertCount(1, Order::all());
    }
}