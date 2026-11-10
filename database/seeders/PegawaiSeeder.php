<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['nama' => 'Budi Santoso', 'nip' => '197805122003121001', 'jabatan' => 'Kepala Seksi Sarana', 'golongan' => 'III/d'],
            ['nama' => 'Siti Rahayu', 'nip' => '198209152006042003', 'jabatan' => 'Staf Administrasi', 'golongan' => 'III/a'],
            ['nama' => 'Ahmad Fauzi', 'nip' => '198603102010011004', 'jabatan' => 'Pengemudi', 'golongan' => 'II/b'],
            ['nama' => 'Dewi Lestari', 'nip' => '199001202015032005', 'jabatan' => 'Bendahara', 'golongan' => 'III/b'],
            ['nama' => 'Rudi Hermawan', 'nip' => '198111052008011006', 'jabatan' => 'Kepala Bidang Pengadaan', 'golongan' => 'IV/a'],
        ];

        foreach ($rows as $row) {
            Pegawai::updateOrCreate(['nip' => $row['nip']], $row);
        }
    }
}
