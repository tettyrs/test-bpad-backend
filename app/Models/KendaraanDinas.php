<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KendaraanDinas extends Model
{
    use SoftDeletes;

    protected $table = 'kendaraan_dinas';

    public const KONDISI = ['baik', 'rusak_ringan', 'rusak_berat'];


    protected $fillable = [
        'nomor_polisi',
        'merk_kendaraan',
        'tipe_kendaraan',
        'tahun_produksi',
        'warna_kendaraan',
        'kondisi',
        'perangkat_daerah_id',
        'pegawai_id',
    ];

    protected function casts(): array
    {
        return [
            'tahun_produksi' => 'integer',
        ];
    }

    public function perangkatDaerah(): BelongsTo
    {
        return $this->belongsTo(PerangkatDaerah::class, 'perangkat_daerah_id');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
