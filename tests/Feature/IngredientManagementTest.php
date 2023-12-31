<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use Database\Seeders\ChefSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class IngredientManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_add_new_ingredient_to_database(): void
    {
        $this->seed(ChefSeeder::class);
        $response = $this->post(route('ingredients.store'), [
            'name' => 'Salt',
            'price' => 1.99
        ]);

        $response->assertOk();
        $this->assertCount(1, Ingredient::all());
        $this->assertEquals('Salt', Ingredient::first()->name);
        $this->assertEquals(1.99, Ingredient::first()->price);
    }

    /** @test */
    public function cannot_add_new_ingredient_without_name_to_database(): void
    {
        $this->seed(ChefSeeder::class);
        $response = $this->post(route('ingredients.store'), [
            'name' => ''
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function cannot_add_new_ingredient_without_price_to_database(): void
    {
        $this->seed(ChefSeeder::class);
        $response = $this->post(route('ingredients.store'), [
            'price' => ''
        ]);

        $response->assertSessionHasErrors('price');
    }

    /** @test */
    public function can_delete_ingredient_from_database(): void
    {
        $this->seed(ChefSeeder::class);
        $this->post(route('ingredients.store'), [
            'name' => 'Salt',
            'price' => 1.99
        ]);

        $ingredient = Ingredient::first();

        $response = $this->delete(route('ingredients.destroy', $ingredient->id));
        $response->assertOk();
        $this->assertCount(0, Ingredient::all());
    }

    /** @test */
    public function user_without_chef_role_cannot_create_and_delete_ingredients(): void
    {
        $this->seed(UserSeeder::class);
        $response = $this->post(route('ingredients.store', [
            'name' => 'Salt',
            'price' => 1.99
        ]));
        $response = $this->delete(route('ingredients.destroy', [
            Ingredient::create([
                'name' => 'Hawaiian',
                'price' => 1.99
            ])
        ]));
        $response->assertUnauthorized();
    }
}