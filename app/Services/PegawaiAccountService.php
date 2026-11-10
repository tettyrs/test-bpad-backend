<?php

namespace App\Services;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PegawaiAccountService
{
    public function create(Pegawai $pegawai, array $data): ?User
    {
        return DB::transaction(function () use ($pegawai, $data) {
            $locked = Pegawai::query()->whereKey($pegawai->id)->lockForUpdate()->first();

            if ($locked->user_id !== null) {
                return null;
            }

            $user = User::create([
                'name' => $locked->nama,
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $locked->user()->associate($user);
            $locked->save();

            return $user;
        });
    }
}
