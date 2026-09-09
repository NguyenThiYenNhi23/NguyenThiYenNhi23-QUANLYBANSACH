<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_phone_number(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'phone' => '0912345678',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'nguyenvana@example.com',
            'phone' => '0912345678',
        ]);
    }
}
