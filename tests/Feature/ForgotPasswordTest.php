<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_is_accessible(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertOk();
        $response->assertSee('Quên mật khẩu');
    }

    public function test_user_can_request_a_reset_link(): void
    {
        User::factory()->create([
            'email' => 'demo@example.com',
        ]);

        $response = $this->post(route('password.email'), [
            'email' => 'demo@example.com',
        ]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHas('status');
    }
}
