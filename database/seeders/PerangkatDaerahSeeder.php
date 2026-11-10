<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerangkatDaerahSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            ['kode_pd' => 'PD-001', 'nama' => 'Dinas Pendidikan'],
            ['kode_pd' => 'PD-002', 'nama' => 'Dinas Kesehatan'],
            ['kode_pd' => 'PD-003', 'nama' => 'Dinas Pekerjaan Umum dan Penataan Ruang (PUPR)'],
            ['kode_pd' => 'PD-004', 'nama' => 'Dinas Sosial'],
            ['kode_pd' => 'PD-005', 'nama' => 'Dinas Perhubungan'],
            ['kode_pd' => 'PD-006', 'nama' => 'Dinas Pertanian'],
        ];

        DB::table('perangkat_daerah')->upsert(
            array_map(fn ($row) => $row + ['created_at' => $now, 'updated_at' => $now], $rows),
            ['kode_pd'],
            ['nama', 'updated_at']
        );
    }
}
