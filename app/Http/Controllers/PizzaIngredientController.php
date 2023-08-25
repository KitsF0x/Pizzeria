<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaIngredientController extends Controller
{
    public function attach(Request $request, Pizza $pizza, Ingredient $ingredient)
    {
        $pizza->ingredients()->attach($ingredient->id);

        return response()->json(['message' => 'Ingredient attached to pizza.']);
    }

    public function detach(Request $request, Pizza $pizza, Ingredient $ingredient)
    {
        $pizza->ingredients()->detach($ingredient->id);
        return response()->json(['message' => 'Ingredient detached from pizza.']);
    }
}