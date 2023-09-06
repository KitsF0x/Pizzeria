<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Pizza;
use App\Models\User;
use Auth;
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

    /** @test */
    public function guest_cannot_order_pizza(): void
    {
        $this->seed(PizzasSeeder::class);
        $response = $this->post(route('order.store'), [
            "user_id" => User::first(),
            "pizza_id" => Pizza::first(),
        ]);

        $response->assertUnauthorized();
    }

    /** @test */
    public function customer_cannot_destroy_others_orders(): void
    {
        // id 1
        $this->seed(CustomerSeeder::class);

        Order::create([
            /* Some big number other than 1 */
            'user_id' => 113,
            /* Some pizza's id*/
            'pizza_id' => 1
        ]);
        $this->assertCount(1, Order::all());

        // Log in customer with id 1
        Auth::login(User::first());

        $response = $this->delete(route('order.destroy', Order::first()));
        $response->assertUnauthorized();
        $this->assertCount(1, Order::all());
    }
}