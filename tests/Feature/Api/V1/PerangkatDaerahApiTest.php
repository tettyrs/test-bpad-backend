<?php

namespace Tests\Feature\Api\V1;

use App\Models\PerangkatDaerah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PerangkatDaerahApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    public function test_crud_flow(): void
    {
        $response = $this->postJson('/api/v1/perangkat-daerah', [
            'kode_pd' => 'PD-010',
            'nama' => 'Dinas Kesehatan',
            'alamat' => 'Jl. Merdeka No. 1',
        ])->assertCreated()
            ->assertJsonPath('data.kode_pd', 'PD-010');

        $id = $response->json('data.id');

        $this->getJson("/api/v1/perangkat-daerah/{$id}")
            ->assertOk()
            ->assertJsonPath('data.nama', 'Dinas Kesehatan');

        $this->putJson("/api/v1/perangkat-daerah/{$id}", ['nama' => 'Dinas Kesehatan Kota'])
            ->assertOk()
            ->assertJsonPath('data.nama', 'Dinas Kesehatan Kota');

        $this->deleteJson("/api/v1/perangkat-daerah/{$id}")
            ->assertOk()
            ->assertJsonPath('data.deleted', true);

        $this->getJson("/api/v1/perangkat-daerah/{$id}")
            ->assertStatus(404);
    }

    public function test_duplicate_kode_pd_is_rejected(): void
    {
        PerangkatDaerah::create(['kode_pd' => 'PD-020', 'nama' => 'Dinas Sosial']);

        $this->postJson('/api/v1/perangkat-daerah', [
            'kode_pd' => 'PD-020',
            'nama' => 'Dinas Lain',
        ])
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['kode_pd']]]);
    }

    public function test_kode_pd_can_be_reused_after_soft_delete(): void
    {
        $this->postJson('/api/v1/perangkat-daerah', ['kode_pd' => 'PD-030', 'nama' => 'Dinas Lama'])
            ->assertCreated();

        $this->deleteJson('/api/v1/perangkat-daerah/'.PerangkatDaerah::where('kode_pd', 'PD-030')->value('id'))
            ->assertOk();

        $this->postJson('/api/v1/perangkat-daerah', ['kode_pd' => 'PD-030', 'nama' => 'Dinas Baru'])
            ->assertCreated()
            ->assertJsonPath('data.nama', 'Dinas Baru');
    }

    public function test_wrong_method_returns_standard_405(): void
    {
        $this->patchJson('/api/v1/perangkat-daerah', [])
            ->assertStatus(405)
            ->assertJsonPath('error.code', 'METHOD_NOT_ALLOWED');
    }
}
