<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PizzaIngredientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_add_ingredient_to_pizza()
    {
        $this->post('/pizzas', [
            'name' => 'Hawaiian'
        ]);

        $this->post('/ingredients', [
            'name' => 'Salt',
            'price' => 1.99
        ]);

        $pizza = Pizza::first();
        $ingredient = Ingredient::first();
        $response = $this->post('pizza_ingredient/' . $pizza->id . '/' . $ingredient->id);

        $response->assertOk();

        $this->assertTrue($pizza->ingredients->contains($ingredient));
        $this->assertEquals('Salt', $pizza->ingredients->first()->name);
        $this->assertCount(1, $pizza->ingredients);
    }
    /** @test */
    public function cannot_add_ingredient_to_pizza_twice()
    {
        $this->post('/pizzas', [
            'name' => 'Hawaiian'
        ]);

        $this->post('/ingredients', [
            'name' => 'Salt',
            'price' => 1.99
        ]);

        $pizza = Pizza::first();
        $ingredient = Ingredient::first();
        $this->post('pizza_ingredient/' . $pizza->id . '/' . $ingredient->id);
        $this->post('pizza_ingredient/' . $pizza->id . '/' . $ingredient->id);

        $this->assertCount(1, $pizza->ingredients);
    }

    /** @test */
    public function can_remove_ingredient_from_pizza()
    {
        $this->post('/pizzas', [
            'name' => 'Hawaiian'
        ]);

        $this->post('/ingredients', [
            'name' => 'Salt',
            'price' => 1.99
        ]);

        $pizza = Pizza::first();
        $ingredient = Ingredient::first();
        $this->post('pizza_ingredient/' . $pizza->id . '/' . $ingredient->id);

        $response = $this->delete('pizza_ingredient/' . $pizza->id . '/' . $ingredient->id);
        $response->assertOk();
        $this->assertCount(0, $pizza->ingredients);
    }
}