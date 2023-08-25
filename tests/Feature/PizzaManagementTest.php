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
}