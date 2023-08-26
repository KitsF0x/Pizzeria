<?php

namespace Database\Seeders;

use App\Models\Pizza;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PizzasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pizza::create([
            'name' => 'Margherita'
        ]);
        Pizza::create([
            'name' => 'Hawaii'
        ]);
    }
}