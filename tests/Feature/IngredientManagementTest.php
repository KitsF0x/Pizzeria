<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class IngredientManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_add_new_ingredient_to_database(): void
    {
        $response = $this->post('ingredients/', [
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
        $response = $this->post('/ingredients', [
            'name' => ''
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function cannot_add_new_ingredient_without_price_to_database(): void
    {
        $response = $this->post('/ingredients', [
            'price' => ''
        ]);

        $response->assertSessionHasErrors('price');
    }

    /** @test */
    public function can_delete_ingredient_from_database(): void
    {
        $this->post('/ingredients', [
            'name' => 'Salt',
            'price' => 1.99
        ]);

        $ingredient = Ingredient::first();

        $response = $this->delete('/ingredients/' . $ingredient->id);
        $response->assertOk();
        $this->assertCount(0, Ingredient::all());
    }
}