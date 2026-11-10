<?php

namespace Tests\Feature\Api\V1;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PegawaiAccountApiTest extends TestCase
{
    use RefreshDatabase;

    private Pegawai $pegawai;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->admin()->create());

        $this->pegawai = Pegawai::create([
            'nama' => 'Siti Rahayu',
            'nip' => '198209152006042003',
            'jabatan' => 'Staf Administrasi',
            'golongan' => 'III/a',
        ]);
    }

    private function payload(array $override = []): array
    {
        return array_merge([
            'email' => 'siti.rahayu@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ], $override);
    }

    public function test_creates_account_linked_to_pegawai(): void
    {
        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload())
            ->assertCreated()
            ->assertJsonPath('data.pegawai_id', $this->pegawai->id)
            ->assertJsonPath('data.user.email', 'siti.rahayu@example.com')
            ->assertJsonMissingPath('data.user.password');

        $user = User::where('email', 'siti.rahayu@example.com')->firstOrFail();

        $this->assertDatabaseHas('pegawai', ['id' => $this->pegawai->id, 'user_id' => $user->id]);
        $this->assertNotSame('rahasia123', $user->password);
    }

    public function test_new_account_can_login(): void
    {
        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload())
            ->assertCreated();

        $this->app['auth']->forgetGuards();

        $this->postJson('/api/v1/auth/login', [
            'email' => 'siti.rahayu@example.com',
            'password' => 'rahasia123',
        ])
            ->assertOk()
            ->assertJsonPath('data.user.email', 'siti.rahayu@example.com');
    }

    public function test_pegawai_cannot_get_second_account(): void
    {
        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload())
            ->assertCreated();

        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload([
            'email' => 'lain@example.com',
        ]))
            ->assertStatus(409)
            ->assertJsonPath('error.code', 'CONFLICT');

        $this->assertDatabaseMissing('users', ['email' => 'lain@example.com']);
    }

    public function test_validates_email_password_and_confirmation(): void
    {
        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", [])
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['email', 'password']]]);

        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload([
            'password_confirmation' => 'beda12345',
        ]))
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['password']]]);

        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload([
            'password' => 'pendek',
            'password_confirmation' => 'pendek',
        ]))
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['password']]]);
    }

    public function test_rejects_duplicate_email(): void
    {
        User::factory()->create(['email' => 'sudah@example.com']);

        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload([
            'email' => 'sudah@example.com',
        ]))
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['email']]]);
    }

    public function test_unknown_pegawai_returns_404(): void
    {
        $this->postJson('/api/v1/pegawai/999999/akun', $this->payload())
            ->assertStatus(404)
            ->assertJsonPath('error.code', 'RESOURCE_NOT_FOUND');
    }

    public function test_deleting_pegawai_revokes_account_access(): void
    {
        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload())
            ->assertCreated();

        $this->app['auth']->forgetGuards();

        $token = $this->postJson('/api/v1/auth/login', [
            'email' => 'siti.rahayu@example.com',
            'password' => 'rahasia123',
        ])->assertOk()->json('data.token');

        $this->app['auth']->forgetGuards();
        Sanctum::actingAs(User::factory()->admin()->create(['email' => 'admin-hapus@example.com']));

        $this->deleteJson("/api/v1/pegawai/{$this->pegawai->id}")
            ->assertOk();

        $this->app['auth']->forgetGuards();

        $this->withToken($token)->getJson('/api/v1/auth/me')
            ->assertStatus(401);

        $this->app['auth']->forgetGuards();

        $this->postJson('/api/v1/auth/login', [
            'email' => 'siti.rahayu@example.com',
            'password' => 'rahasia123',
        ])
            ->assertStatus(401)
            ->assertJsonPath('error.code', 'INVALID_CREDENTIALS');

        $this->assertDatabaseMissing('users', ['email' => 'siti.rahayu@example.com']);
    }

    public function test_password_longer_than_255_is_rejected(): void
    {
        $panjang = str_repeat('a', 256);

        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload([
            'password' => $panjang,
            'password_confirmation' => $panjang,
        ]))
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['password']]]);
    }

    public function test_operator_cannot_create_account(): void
    {
        Sanctum::actingAs(User::factory()->create(['email' => 'operator-uji@example.com']));

        $this->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload())
            ->assertStatus(403)
            ->assertJsonPath('error.code', 'FORBIDDEN');

        $this->assertDatabaseMissing('users', ['email' => 'siti.rahayu@example.com']);
        $this->assertDatabaseHas('pegawai', ['id' => $this->pegawai->id, 'user_id' => null]);
    }

    public function test_requires_authentication(): void
    {
        $this->app['auth']->forgetGuards();

        $this->withHeader('Authorization', 'Bearer token-palsu')
            ->postJson("/api/v1/pegawai/{$this->pegawai->id}/akun", $this->payload())
            ->assertStatus(401)
            ->assertJsonPath('error.code', 'UNAUTHENTICATED');
    }
}
