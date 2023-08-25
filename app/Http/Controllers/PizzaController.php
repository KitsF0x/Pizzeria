<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function store(Request $request)
    {
        Pizza::create($request->all());
        return redirect('/pizzas');
    }
}