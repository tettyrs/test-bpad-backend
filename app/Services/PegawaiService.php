<?php

namespace App\Services;

use App\Models\Pegawai;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PegawaiService
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        $search = isset($filters['search']) ? addcslashes($filters['search'], '%_\\') : null;

        return Pegawai::query()
            ->when($search, fn ($query) => $query->where(fn ($q) => $q
                ->where('nama', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")))
            ->orderBy('nama')
            ->paginate($filters['per_page'] ?? 10);
    }

    public function create(array $data): Pegawai
    {
        return Pegawai::create($data);
    }

    public function update(Pegawai $pegawai, array $data): Pegawai
    {
        $pegawai->update($data);

        return $pegawai->refresh();
    }

    public function delete(Pegawai $pegawai): void
    {
        DB::transaction(function () use ($pegawai) {
            $user = $pegawai->user;

            if ($user !== null) {
                $user->tokens()->delete();
                $user->delete();
            }

            $pegawai->delete();
        });
    }
}
