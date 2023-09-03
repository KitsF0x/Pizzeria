<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Pizza;
use Database\Seeders\ChefSeeder;
use Database\Seeders\IngredientsSeeder;
use Database\Seeders\PizzasSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PizzaIngredientManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_add_ingredient_to_pizza()
    {
        $this->seed(ChefSeeder::class);
        $this->post(route('pizzas.store'), [
            'name' => 'Hawaiian'
        ]);

        $this->post(route('ingredients.store'), [
            'name' => 'Salt',
            'price' => 1.99
        ]);

        $pizza = Pizza::first();
        $ingredient = Ingredient::first();
        $response = $this->post(route('pizza_ingredients.attach', [$pizza->id, $ingredient->id]));

        $response->assertOk();

        $this->assertTrue($pizza->ingredients->contains($ingredient));
        $this->assertEquals('Salt', $pizza->ingredients->first()->name);
        $this->assertCount(1, $pizza->ingredients);
    }
    /** @test */
    public function cannot_add_ingredient_to_pizza_twice()
    {
        $this->seed(ChefSeeder::class);
        $this->post(route('pizzas.store'), [
            'name' => 'Hawaiian'
        ]);

        $this->post(route('ingredients.store'), [
            'name' => 'Salt',
            'price' => 1.99
        ]);

        $pizza = Pizza::first();
        $ingredient = Ingredient::first();
        $this->post(route('pizza_ingredients.attach', [$pizza->id, $ingredient->id]));
        $this->post(route('pizza_ingredients.attach', [$pizza->id, $ingredient->id]));

        $this->assertCount(1, $pizza->ingredients);
    }

    /** @test */
    public function can_remove_ingredient_from_pizza()
    {
        $this->seed(ChefSeeder::class);
        $this->post(route('pizzas.store'), [
            'name' => 'Hawaiian'
        ]);

        $this->post(route('ingredients.store'), [
            'name' => 'Salt',
            'price' => 1.99
        ]);

        $pizza = Pizza::first();
        $ingredient = Ingredient::first();
        $this->post(route('pizza_ingredients.attach', [$pizza->id, $ingredient->id]));

        $response = $this->delete(route('pizza_ingredients.detach', [$pizza->id, $ingredient->id]));
        $response->assertOk();
        $this->assertCount(0, $pizza->ingredients);
    }

    /** @test */
    public function can_delete_records_with_id_of_deleted_ingredient(): void
    {
        // Seed database 
        $this->seed(ChefSeeder::class);
        $this->seed(IngredientsSeeder::class);
        $this->seed(PizzasSeeder::class);

        // Get models into variables
        $pizza = Pizza::where('id', 1)->first();
        $ingredientSalt = Ingredient::where('id', 1)->first();
        $ingredientOlives = Ingredient::where('id', 2)->first();

        // Assert correctness of the variables and models
        $this->assertEquals('Salt', $ingredientSalt->name);
        $this->assertEquals('Olives', $ingredientOlives->name);

        // Connect pizza with ingredients
        $this->post(route('pizza_ingredients.attach', [$pizza->id, $ingredientSalt->id]));
        $this->post(route('pizza_ingredients.attach', [$pizza->id, $ingredientOlives->id]));

        // Assert that pizza has 2 ingredients
        $this->assertCount(2, $pizza->ingredients);

        // Delete olives from database(id: 2)
        $this->delete(route('ingredients.destroy', $ingredientOlives->id));

        // Assert that deletion was successful
        $this->assertCount(1, Pizza::first()->ingredients);

        // Assert that removed correct model
        $this->assertEquals('Salt', $pizza->ingredients->first()->name);
    }
}