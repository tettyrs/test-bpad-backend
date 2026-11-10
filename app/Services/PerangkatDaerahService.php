<?php

namespace App\Services;

use App\Models\PerangkatDaerah;
use Illuminate\Pagination\LengthAwarePaginator;

class PerangkatDaerahService
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        $search = isset($filters['search']) ? addcslashes($filters['search'], '%_\\') : null;

        return PerangkatDaerah::query()
            ->when($search, fn ($query) => $query->where(fn ($q) => $q
                ->where('nama', 'like', "%{$search}%")
                ->orWhere('kode_pd', 'like', "%{$search}%")))
            ->orderBy('nama')
            ->paginate($filters['per_page'] ?? 10);
    }

    public function create(array $data): PerangkatDaerah
    {
        return PerangkatDaerah::create($data);
    }

    public function update(PerangkatDaerah $perangkatDaerah, array $data): PerangkatDaerah
    {
        $perangkatDaerah->update($data);

        return $perangkatDaerah->refresh();
    }

    public function delete(PerangkatDaerah $perangkatDaerah): void
    {
        $perangkatDaerah->delete();
    }
}
