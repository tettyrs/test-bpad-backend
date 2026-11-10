<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KendaraanDinasResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nomor_polisi' => $this->nomor_polisi,
            'merk_kendaraan' => $this->merk_kendaraan,
            'tipe_kendaraan' => $this->tipe_kendaraan,
            'tahun_produksi' => $this->tahun_produksi,
            'warna_kendaraan' => $this->warna_kendaraan,
            'kondisi' => $this->kondisi,
            'perangkat_daerah' => $this->whenLoaded('perangkatDaerah', fn () => new PerangkatDaerahResource($this->perangkatDaerah)),
            'pegawai' => $this->whenLoaded('pegawai', fn () => $this->pegawai ? new PegawaiResource($this->pegawai) : null),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
