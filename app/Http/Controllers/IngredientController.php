<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);
        Ingredient::create($validatedData);
    }
    public function destroy(Request $request, Ingredient $pizza)
    {
        $pizza->delete();
    }
}