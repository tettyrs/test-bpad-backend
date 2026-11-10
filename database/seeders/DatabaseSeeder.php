<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password']
        );
        $admin->forceFill(['role' => User::ROLE_ADMIN])->save();

        $operator = User::updateOrCreate(
            ['email' => 'operator@example.com'],
            ['name' => 'Operator Uji', 'password' => 'password']
        );
        $operator->forceFill(['role' => User::ROLE_OPERATOR])->save();

        $this->call([
            PerangkatDaerahSeeder::class,
            PegawaiSeeder::class,
            KendaraanDinasSeeder::class,
        ]);
    }
}
