<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_login_redirects_to_customer_home(): void
    {
        User::create([
            'name' => 'Khách hàng A',
            'email' => 'customer@example.com',
            'phone' => '0912345671',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'customer@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('customer.home'));
    }
}
