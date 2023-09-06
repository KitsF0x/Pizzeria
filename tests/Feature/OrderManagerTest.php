<?php

namespace Tests\Feature;

use App\Models\Order;
use Database\Seeders\OrderManagerSeeder;
use Database\Seeders\OrderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderManagerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_user_with_order_manager_role_delete_order(): void
    {
        $this->seed(OrderManagerSeeder::class);
        $this->seed(OrderSeeder::class);

        $this->assertCount(1, Order::all());

        $response = $this->delete(route('order.destroy', [Order::first()]));

        $response->assertOk();
        $this->assertCount(0, Order::all());
    }
}