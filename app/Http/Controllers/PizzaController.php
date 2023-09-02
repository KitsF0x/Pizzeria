<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Auth;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::guest()) {
            return response("Unauthorized", 401);
        }
        $validatedData = $request->validate([
            'name' => 'required|unique:App\Models\Pizza,name'
        ]);
        Pizza::create($validatedData);
    }

    public function destroy(Request $request, Pizza $pizza)
    {
        if (Auth::guest()) {
            return response("Unauthorized", 401);
        }
        $pizza->delete();
    }
}