<?php

namespace Tests\Feature;

use App\Models\Pizza;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PizzaManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_add_new_pizza_to_database(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/pizzas', [
            'name' => 'Hawaiian'
        ]);

        $response->assertRedirect('/pizzas');
        $this->assertCount(1, Pizza::all());
    }

    /** @test */
    public function cannot_add_new_pizza_without_name_to_database(): void
    {
        $response = $this->post('/pizzas', [
            'name' => ''
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function cannot_add_pizza_with_already_used_name(): void
    {
        $this->post('/pizzas', [
            'name' => 'Hawaiian'
        ]);
        $response = $this->post('/pizzas', [
            'name' => 'Hawaiian'
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertCount(1, Pizza::all());
    }
}