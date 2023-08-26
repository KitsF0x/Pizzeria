<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:App\Models\Pizza,name'
        ]);
        Pizza::create($validatedData);
    }

    public function destroy(Request $request, Pizza $pizza)
    {
        $pizza->delete();
    }
}