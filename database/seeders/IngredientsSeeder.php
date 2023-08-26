<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    public function run(): void
    {
        Ingredient::create([
            'name' => 'Salt',
            'price' => 1.99
        ]);
        Ingredient::create([
            'name' => 'Olives',
            'price' => 1.50
        ]);
        Ingredient::create([
            'name' => 'Pepperoni',
            'price' => 2.00
        ]);
    }
}