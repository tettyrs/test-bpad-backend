<?php

namespace Tests\Feature\Api\V1;

use App\Models\KendaraanDinas;
use App\Models\PerangkatDaerah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class KendaraanDinasApiTest extends TestCase
{
    use RefreshDatabase;

    private PerangkatDaerah $pd;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());

        $this->pd = PerangkatDaerah::create([
            'kode_pd' => 'PD-001',
            'nama' => 'Dinas Pendidikan',
        ]);
    }

    private function payload(array $override = []): array
    {
        return array_merge([
            'nomor_polisi' => 'b 1234 abc',
            'merk_kendaraan' => 'Toyota',
            'tipe_kendaraan' => 'Avanza G',
            'tahun_produksi' => 2020,
            'warna_kendaraan' => 'Hitam',
            'kondisi' => 'baik',
            'perangkat_daerah_id' => $this->pd->id,
        ], $override);
    }

    public function test_can_create_kendaraan_dinas_and_nomor_polisi_is_normalized(): void
    {
        $this->postJson('/api/v1/kendaraan-dinas', $this->payload())
            ->assertCreated()
            ->assertJsonPath('data.nomor_polisi', 'B 1234 ABC')
            ->assertJsonPath('data.perangkat_daerah.nama', 'Dinas Pendidikan');

        $this->assertDatabaseHas('kendaraan_dinas', ['nomor_polisi' => 'B 1234 ABC']);
    }

    public function test_create_returns_validation_error_envelope(): void
    {
        $this->postJson('/api/v1/kendaraan-dinas', [])
            ->assertStatus(422)
            ->assertJsonPath('error.code', 'VALIDATION_ERROR')
            ->assertJsonStructure(['error' => ['code', 'message', 'details' => [
                'nomor_polisi', 'merk_kendaraan', 'tahun_produksi', 'warna_kendaraan', 'kondisi', 'perangkat_daerah_id',
            ]]]);
    }

    public function test_rejects_invalid_plate_kondisi_and_year(): void
    {
        $this->postJson('/api/v1/kendaraan-dinas', $this->payload([
            'nomor_polisi' => '12345',
            'kondisi' => 'hancur',
            'tahun_produksi' => 1800,
        ]))
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['nomor_polisi', 'kondisi', 'tahun_produksi']]]);
    }

    public function test_rejects_duplicate_nomor_polisi(): void
    {
        KendaraanDinas::create($this->payload(['nomor_polisi' => 'B 1234 ABC']));

        $this->postJson('/api/v1/kendaraan-dinas', $this->payload())
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['nomor_polisi']]]);
    }

    public function test_index_is_paginated_and_searchable(): void
    {
        KendaraanDinas::create($this->payload(['nomor_polisi' => 'B 1111 AAA', 'merk_kendaraan' => 'Honda']));
        KendaraanDinas::create($this->payload(['nomor_polisi' => 'B 2222 BBB', 'merk_kendaraan' => 'Toyota']));

        $this->getJson('/api/v1/kendaraan-dinas?search=Honda')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.merk_kendaraan', 'Honda');

        $this->getJson('/api/v1/kendaraan-dinas?per_page=1')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('meta.per_page', 1)
            ->assertJsonPath('meta.total', 2);
    }

    public function test_show_update_and_soft_delete(): void
    {
        $kendaraan = KendaraanDinas::create($this->payload());

        $this->getJson("/api/v1/kendaraan-dinas/{$kendaraan->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $kendaraan->id);

        $this->putJson("/api/v1/kendaraan-dinas/{$kendaraan->id}", ['kondisi' => 'rusak_berat'])
            ->assertOk()
            ->assertJsonPath('data.kondisi', 'rusak_berat');

        $this->deleteJson("/api/v1/kendaraan-dinas/{$kendaraan->id}")
            ->assertOk()
            ->assertJsonPath('data.deleted', true);

        $this->assertSoftDeleted('kendaraan_dinas', ['id' => $kendaraan->id]);

        $this->getJson("/api/v1/kendaraan-dinas/{$kendaraan->id}")
            ->assertStatus(404)
            ->assertJsonPath('error.code', 'RESOURCE_NOT_FOUND');
    }

    public function test_update_keeps_own_nomor_polisi_valid(): void
    {
        $kendaraan = KendaraanDinas::create($this->payload());

        $this->putJson("/api/v1/kendaraan-dinas/{$kendaraan->id}", [
            'nomor_polisi' => 'B 1234 ABC',
            'warna_kendaraan' => 'Putih',
        ])->assertOk()->assertJsonPath('data.warna_kendaraan', 'Putih');
    }

    public function test_nomor_polisi_can_be_reused_after_soft_delete(): void
    {
        $lama = KendaraanDinas::create($this->payload(['nomor_polisi' => 'B 4321 DEF']));
        $lama->delete();

        $this->postJson('/api/v1/kendaraan-dinas', $this->payload(['nomor_polisi' => 'B 4321 DEF']))
            ->assertCreated()
            ->assertJsonPath('data.nomor_polisi', 'B 4321 DEF');
    }

    public function test_nomor_polisi_of_active_record_is_still_protected(): void
    {
        $kendaraan = KendaraanDinas::create($this->payload(['nomor_polisi' => 'B 5555 GHI']));
        $lain = KendaraanDinas::create($this->payload(['nomor_polisi' => 'B 6666 JKL']));

        $this->putJson("/api/v1/kendaraan-dinas/{$lain->id}", ['nomor_polisi' => 'B 5555 GHI'])
            ->assertStatus(422)
            ->assertJsonStructure(['error' => ['details' => ['nomor_polisi']]]);

        $this->assertDatabaseHas('kendaraan_dinas', ['id' => $kendaraan->id, 'nomor_polisi' => 'B 5555 GHI']);
    }

    public function test_unknown_route_returns_standard_404(): void
    {
        $this->getJson('/api/v1/tidak-ada')
            ->assertStatus(404)
            ->assertJsonPath('error.code', 'ENDPOINT_NOT_FOUND');
    }
}
