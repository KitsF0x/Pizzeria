<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_create_new_user(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->post('register/', [
            'name' => 'testUsername',
            'email' => 'test@gmail.com',
            'password' => 'test1234abcd',
            'password_confirmation' => 'test1234abcd'
        ]);
        $response->assertRedirect('/home');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function can_seed_database_with_test_user(): void
    {
        $this->seed(UserSeeder::class);

        $this->assertCount(1, User::all());

        $user = User::first();

        $this->assertEquals('testUsername', $user->name);
        $this->assertEquals('test@gmail.com', $user->email);
        $this->assertTrue(Hash::check('test1234abcd', $user->password));
    }
}