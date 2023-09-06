<?php

namespace Database\Seeders;

use App\Enum\Roles;
use App\Models\User;
use Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'testUsername',
            'email' => 'test@gmail.com',
            'password' => 'test1234abcd',
            'role_number' => Roles::ORDER_MANAGER
        ]);

        Auth::login($user);
    }
}