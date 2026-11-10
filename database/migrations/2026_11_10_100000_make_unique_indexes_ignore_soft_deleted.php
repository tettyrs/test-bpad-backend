<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->swapUnique('perangkat_daerah', 'kode_pd', 20);
        $this->swapUnique('pegawai', 'nip', 30);
        $this->swapUnique('kendaraan_dinas', 'nomor_polisi', 20);
    }

    public function down(): void
    {
        $this->restoreUnique('perangkat_daerah', 'kode_pd', 20);
        $this->restoreUnique('pegawai', 'nip', 30);
        $this->restoreUnique('kendaraan_dinas', 'nomor_polisi', 20);
    }

    private function swapUnique(string $table, string $column, int $length): void
    {
        Schema::table($table, function (Blueprint $t) use ($table, $column) {
            $t->dropUnique($table.'_'.$column.'_unique');
        });

        Schema::table($table, function (Blueprint $t) use ($column, $length) {
            $t->string($column.'_aktif', $length)
                ->nullable()
                ->storedAs("if(deleted_at is null, {$column}, null)")
                ->unique();
        });
    }

    private function restoreUnique(string $table, string $column, int $length): void
    {
        Schema::table($table, function (Blueprint $t) use ($column) {
            $t->dropUnique([$column.'_aktif']);
            $t->dropColumn($column.'_aktif');
        });

        Schema::table($table, function (Blueprint $t) use ($column) {
            $t->unique($column);
        });
    }
};
