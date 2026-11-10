<?php

namespace Database\Seeders;

use App\Models\KendaraanDinas;
use App\Models\PerangkatDaerah;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class KendaraanDinasSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['nomor_polisi' => 'B 1234 SDK', 'merk_kendaraan' => 'Toyota', 'tipe_kendaraan' => 'Avanza G', 'tahun_produksi' => 2019, 'warna_kendaraan' => 'Hitam', 'kondisi' => 'baik', 'kode_pd' => 'PD-001', 'nip' => '197805122003121001'],
            ['nomor_polisi' => 'D 5678 PKP', 'merk_kendaraan' => 'Mitsubishi', 'tipe_kendaraan' => 'Pajero Sport', 'tahun_produksi' => 2021, 'warna_kendaraan' => 'Putih', 'kondisi' => 'baik', 'kode_pd' => 'PD-002', 'nip' => '198209152006042003'],
            ['nomor_polisi' => 'AB 9012 KL', 'merk_kendaraan' => 'Isuzu', 'tipe_kendaraan' => 'Panther', 'tahun_produksi' => 2015, 'warna_kendaraan' => 'Silver', 'kondisi' => 'rusak_ringan', 'kode_pd' => 'PD-003', 'nip' => '198603102010011004'],
            ['nomor_polisi' => 'B 3456 XYZ', 'merk_kendaraan' => 'Daihatsu', 'tipe_kendaraan' => 'Terios', 'tahun_produksi' => 2017, 'warna_kendaraan' => 'Abu-abu', 'kondisi' => 'rusak_berat', 'kode_pd' => 'PD-004', 'nip' => null],
            ['nomor_polisi' => 'T 7890 DKS', 'merk_kendaraan' => 'Toyota', 'tipe_kendaraan' => 'Innova Reborn', 'tahun_produksi' => 2022, 'warna_kendaraan' => 'Hitam', 'kondisi' => 'baik', 'kode_pd' => 'PD-005', 'nip' => '199001202015032005'],
            ['nomor_polisi' => 'DK 2468 SOS', 'merk_kendaraan' => 'Suzuki', 'tipe_kendaraan' => 'Ertiga', 'tahun_produksi' => 2020, 'warna_kendaraan' => 'Merah', 'kondisi' => 'baik', 'kode_pd' => 'PD-006', 'nip' => null],
        ];

        foreach ($rows as $row) {
            $perangkatDaerahId = PerangkatDaerah::where('kode_pd', $row['kode_pd'])->value('id');
            $pegawaiId = $row['nip'] ? Pegawai::where('nip', $row['nip'])->value('id') : null;

            KendaraanDinas::updateOrCreate(
                ['nomor_polisi' => $row['nomor_polisi']],
                [
                    'merk_kendaraan' => $row['merk_kendaraan'],
                    'tipe_kendaraan' => $row['tipe_kendaraan'],
                    'tahun_produksi' => $row['tahun_produksi'],
                    'warna_kendaraan' => $row['warna_kendaraan'],
                    'kondisi' => $row['kondisi'],
                    'perangkat_daerah_id' => $perangkatDaerahId,
                    'pegawai_id' => $pegawaiId,
                ]
            );
        }
    }
}
