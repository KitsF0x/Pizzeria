<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Pizza;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PizzaManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_add_new_pizza_to_database(): void
    {
        $this->seed(UserSeeder::class);
        $response = $this->post(route('pizzas.store'), [
            'name' => 'Hawaiian'
        ]);

        $response->assertOk();
        $this->assertCount(1, Pizza::all());
        $this->assertEquals('Hawaiian', Pizza::first()->name);
    }

    /** @test */
    public function cannot_add_new_pizza_without_name_to_database(): void
    {
        $this->seed(UserSeeder::class);
        $response = $this->post(route('pizzas.store'), [
            'name' => ''
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function cannot_add_pizza_with_already_used_name(): void
    {
        $this->seed(UserSeeder::class);
        $this->post(route('pizzas.store'), [
            'name' => 'Hawaiian'
        ]);
        $response = $this->post(route('pizzas.store'), [
            'name' => 'Hawaiian'
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertCount(1, Pizza::all());
    }

    /** @test */
    public function can_delete_pizza_from_database(): void
    {
        $this->seed(UserSeeder::class);
        $this->post(route('pizzas.store'), [
            'name' => 'Hawaiian'
        ]);

        $pizza = Pizza::first();

        $response = $this->delete(route('pizzas.destroy', $pizza->id));
        $response->assertOk();
        $this->assertCount(0, Pizza::all());
    }

    /** @test */
    public function guest_cannot_create_and_delete_pizzas(): void
    {
        $response = $this->post(route('pizzas.store', [
            'name' => 'Hawaiian'
        ]));

        $response->assertUnauthorized();
        $this->assertCount(0, Pizza::all());
    }
}