<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function is_user_default_role_number_is_zero(): void
    {
        $this->seed(UserSeeder::class);
        $this->assertEquals(0, User::first()->role_number);
    }
}