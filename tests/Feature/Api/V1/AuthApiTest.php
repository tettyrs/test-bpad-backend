<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_bearer_token(): void
    {
        $user = User::factory()->create(['email' => 'admin@example.com']);

        $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])
            ->assertOk()
            ->assertJsonStructure(['data' => ['token', 'token_type', 'expires_in', 'user' => ['id', 'name', 'email']]])
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonPath('data.user.id', $user->id)
            ->assertJsonMissingPath('data.user.password');
    }

    public function test_login_with_wrong_password_returns_standard_error(): void
    {
        User::factory()->create(['email' => 'wrong@example.com']);

        $this->postJson('/api/v1/auth/login', [
            'email' => 'wrong@example.com',
            'password' => 'salah',
        ])
            ->assertStatus(401)
            ->assertJsonPath('error.code', 'INVALID_CREDENTIALS');
    }

    public function test_login_validates_input(): void
    {
        $this->postJson('/api/v1/auth/login', ['email' => 'bukan-email'])
            ->assertStatus(422)
            ->assertJsonPath('error.code', 'VALIDATION_ERROR')
            ->assertJsonStructure(['error' => ['details' => ['email', 'password']]]);
    }

    public function test_login_is_limited_per_ip_across_many_emails(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $this->postJson('/api/v1/auth/login', [
                'email' => "orang{$i}@example.com",
                'password' => 'salah-banget',
            ])->assertStatus(401);
        }

        $this->postJson('/api/v1/auth/login', [
            'email' => 'orang21@example.com',
            'password' => 'salah-banget',
        ])
            ->assertStatus(429)
            ->assertJsonPath('error.code', 'TOO_MANY_REQUESTS');
    }

    public function test_login_with_array_email_returns_validation_error_not_server_error(): void
    {
        $this->postJson('/api/v1/auth/login', [
            'email' => ['a@example.com'],
            'password' => 'password',
        ])
            ->assertStatus(422)
            ->assertJsonPath('error.code', 'VALIDATION_ERROR');
    }

    public function test_protected_endpoint_requires_token(): void
    {
        $this->getJson('/api/v1/kendaraan-dinas')
            ->assertStatus(401)
            ->assertJsonPath('error.code', 'UNAUTHENTICATED');
    }

    public function test_me_and_logout_with_token(): void
    {
        User::factory()->create(['email' => 'me@example.com']);

        $token = $this->postJson('/api/v1/auth/login', [
            'email' => 'me@example.com',
            'password' => 'password',
        ])->json('data.token');

        $this->withToken($token)->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJsonPath('data.email', 'me@example.com');

        $this->withToken($token)->postJson('/api/v1/auth/logout')
            ->assertOk();

        $this->app['auth']->forgetGuards();

        $this->withToken($token)->getJson('/api/v1/auth/me')
            ->assertStatus(401);
    }
}
