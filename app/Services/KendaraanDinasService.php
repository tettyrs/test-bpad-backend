<?php

namespace App\Services;

use App\Models\KendaraanDinas;
use Illuminate\Pagination\LengthAwarePaginator;

class KendaraanDinasService
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        $search = isset($filters['search']) ? addcslashes($filters['search'], '%_\\') : null;

        return KendaraanDinas::query()
            ->with(['perangkatDaerah', 'pegawai'])
            ->when($filters['kondisi'] ?? null, fn ($query, $kondisi) => $query->where('kondisi', $kondisi))
            ->when($search, fn ($query) => $query->where(fn ($q) => $q
                ->where('nomor_polisi', 'like', "%{$search}%")
                ->orWhere('merk_kendaraan', 'like', "%{$search}%")))
            ->latest('id')
            ->paginate($filters['per_page'] ?? 10);
    }

    public function create(array $data): KendaraanDinas
    {
        return KendaraanDinas::create($data)->load(['perangkatDaerah', 'pegawai']);
    }

    public function update(KendaraanDinas $kendaraanDinas, array $data): KendaraanDinas
    {
        $kendaraanDinas->update($data);

        return $kendaraanDinas->refresh()->load(['perangkatDaerah', 'pegawai']);
    }

    public function delete(KendaraanDinas $kendaraanDinas): void
    {
        $kendaraanDinas->delete();
    }
}
