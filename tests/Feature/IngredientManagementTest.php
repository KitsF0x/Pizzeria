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
            'name' => 'Salt'
        ]);

        $response->assertRedirect('ingredients/');
        $this->assertCount(1, Ingredient::all());
        $this->assertEquals('Salt', Ingredient::first()->name);
    }
}