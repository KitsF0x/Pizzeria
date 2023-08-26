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

    /** @test */
    public function can_delete_records_with_id_of_deleted_ingredient(): void
    {
        // Create 2 ingredients 
        $this->post('/ingredients', [
            'name' => 'Salt',
            'price' => 1.99
        ]);
        $this->post('/ingredients', [
            'name' => 'Olives',
            'price' => 5.99
        ]);

        // Create 1 pizza
        $this->post('/pizzas', [
            'name' => 'Hawaiian'
        ]);

        // Get models into variables
        $pizza = Pizza::first();
        $ingredientSalt = Ingredient::where('id', 1)->first();
        $ingredientOlives = Ingredient::where('id', 2)->first();

        // Assert correctness of the variables and models
        $this->assertEquals('Salt', $ingredientSalt->name);
        $this->assertEquals('Olives', $ingredientOlives->name);

        // Connect pizza with ingredients
        $this->post('pizza_ingredient/' . $pizza->id . '/' . $ingredientSalt->id);
        $this->post('pizza_ingredient/' . $pizza->id . '/' . $ingredientOlives->id);

        // Assert that pizza has 2 ingredients
        $this->assertCount(2, $pizza->ingredients);

        // Delete olives from database(id: 2)
        $this->delete('ingredients/' . $ingredientOlives->id);

        // Assert that deletion was successful
        $this->assertCount(1, Pizza::first()->ingredients);

        // Assert that removed correct model
        $this->assertEquals('Salt', $pizza->ingredients->first()->name);
    }
}