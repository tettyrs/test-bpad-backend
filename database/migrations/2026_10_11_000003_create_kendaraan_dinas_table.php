<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKendaraanDinasTable extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraan_dinas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_polisi', 20)->unique();
            $table->string('merk_kendaraan', 100);
            $table->string('tipe_kendaraan', 100)->nullable();
            $table->unsignedSmallInteger('tahun_produksi');
            $table->string('warna_kendaraan', 50);
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->foreignId('perangkat_daerah_id')->nullable()->constrained('perangkat_daerah')->nullOnDelete();
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawai')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraan_dinas');
    }
}
