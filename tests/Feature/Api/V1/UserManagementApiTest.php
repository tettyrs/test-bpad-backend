<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserManagementApiTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['email' => 'admin@example.com']);
        Sanctum::actingAs($this->admin);
    }

    private function payload(array $override = []): array
    {
        return array_merge([
            'name' => 'Dewi Lestari',
            'email' => 'Dewi@Example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'role' => 'operator',
        ], $override);
    }

    public function test_operator_cannot_access_user_management(): void
    {
        Sanctum::actingAs(User::factory()->create(['email' => 'op@example.com']));

        $this->getJson('/api/v1/users')->assertStatus(403)->assertJsonPath('error.code', 'FORBIDDEN');
        $this->postJson('/api/v1/users', $this->payload())->assertStatus(403);
    }

    public function test_admin_creates_user_with_normalized_email_and_default_active(): void
    {
        $this->postJson('/api/v1/users', $this->payload())
            ->assertCreated()
            ->assertJsonPath('data.email', 'dewi@example.com')
            ->assertJsonPath('data.role', 'operator')
            ->assertJsonPath('data.is_active', true)
            ->assertJsonMissingPath('data.password');

        $this->assertDatabaseHas('users', ['email' => 'dewi@example.com', 'is_active' => true]);
    }

    public function test_create_rejects_duplicate_email_and_bad_role(): void
    {
        User::factory()->create(['email' => 'ada@example.com']);

        $this->postJson('/api/v1/users', $this->payload(['email' => 'ada@example.com']))
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['email']]]);

        $this->postJson('/api/v1/users', $this->payload(['role' => 'superuser']))
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['role']]]);
    }

    public function test_index_filters_by_role_and_status(): void
    {
        User::factory()->create(['name' => 'Operator Aktif', 'role' => 'operator']);
        User::factory()->create(['name' => 'Operator Nonaktif', 'role' => 'operator', 'is_active' => false]);

        $this->getJson('/api/v1/users?role=operator&is_active=0')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Operator Nonaktif');
    }

    public function test_admin_can_change_another_users_role(): void
    {
        $target = User::factory()->create(['role' => 'operator']);

        $this->putJson("/api/v1/users/{$target->id}", ['role' => 'admin'])
            ->assertOk()
            ->assertJsonPath('data.role', 'admin');
    }

    public function test_admin_cannot_change_own_role(): void
    {
        $this->putJson("/api/v1/users/{$this->admin->id}", ['role' => 'operator'])
            ->assertStatus(409)
            ->assertJsonPath('error.code', 'CONFLICT');

        $this->assertDatabaseHas('users', ['id' => $this->admin->id, 'role' => 'admin']);
    }

    public function test_cannot_demote_or_deactivate_last_active_admin(): void
    {
        $this->putJson("/api/v1/users/{$this->admin->id}", ['role' => 'operator'])
            ->assertStatus(409);

        $other = User::factory()->admin()->create();

        $this->putJson("/api/v1/users/{$other->id}/status", ['is_active' => false])
            ->assertOk();

        $this->putJson("/api/v1/users/{$this->admin->id}/status", ['is_active' => false])
            ->assertStatus(409);
    }

    public function test_admin_cannot_deactivate_self(): void
    {
        $this->putJson("/api/v1/users/{$this->admin->id}/status", ['is_active' => false])
            ->assertStatus(409)
            ->assertJsonPath('error.message', 'Anda tidak bisa menonaktifkan akun sendiri.');
    }

    public function test_deactivated_user_cannot_login_and_tokens_are_revoked(): void
    {
        $target = User::factory()->create(['email' => 'nonaktif@example.com', 'password' => 'rahasia123']);
        $token = $target->createToken('api')->plainTextToken;

        $this->putJson("/api/v1/users/{$target->id}/status", ['is_active' => false])
            ->assertOk()
            ->assertJsonPath('data.is_active', false);

        $this->assertDatabaseCount('personal_access_tokens', 0);

        $this->app['auth']->forgetGuards();

        $this->postJson('/api/v1/auth/login', [
            'email' => 'nonaktif@example.com',
            'password' => 'rahasia123',
        ])
            ->assertStatus(401)
            ->assertJsonPath('error.code', 'INVALID_CREDENTIALS');

        $this->app['auth']->forgetGuards();

        $this->withToken($token)->getJson('/api/v1/auth/me')->assertStatus(401);
    }

    public function test_reactivated_user_can_login_again(): void
    {
        $target = User::factory()->create(['email' => 'kembali@example.com', 'password' => 'rahasia123', 'is_active' => false]);

        $this->putJson("/api/v1/users/{$target->id}/status", ['is_active' => true])
            ->assertOk();

        $this->app['auth']->forgetGuards();

        $this->postJson('/api/v1/auth/login', [
            'email' => 'kembali@example.com',
            'password' => 'rahasia123',
        ])->assertOk();
    }

    public function test_reset_password_changes_login_and_revokes_old_tokens(): void
    {
        $target = User::factory()->create(['email' => 'reset@example.com', 'password' => 'lama12345']);
        $oldToken = $target->createToken('api')->plainTextToken;

        $this->postJson("/api/v1/users/{$target->id}/reset-password", [
            'password' => 'baru12345',
            'password_confirmation' => 'baru12345',
        ])->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 0);

        $this->app['auth']->forgetGuards();

        $this->withToken($oldToken)->getJson('/api/v1/auth/me')->assertStatus(401);

        $this->app['auth']->forgetGuards();

        $this->postJson('/api/v1/auth/login', [
            'email' => 'reset@example.com',
            'password' => 'baru12345',
        ])->assertOk();
    }

    public function test_unknown_user_returns_404(): void
    {
        $this->getJson('/api/v1/users/999999')
            ->assertStatus(404)
            ->assertJsonPath('error.code', 'RESOURCE_NOT_FOUND');
    }
}
