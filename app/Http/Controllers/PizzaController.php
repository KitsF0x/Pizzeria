<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Roles;
use Auth;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::guest()) {
            return response("Unauthorized", 401);
        }
        if (Auth::user()->role_number != Roles::CHEF) {
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
        if (Auth::user()->role_number != Roles::CHEF) {
            return response("Unauthorized", 401);
        }
        $pizza->delete();
    }
}