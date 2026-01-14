<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Posyandu - Data titik layanan (Posyandu Mawar, Melati, dll)
     */
    public function up(): void
    {
        Schema::create('posyandus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');                    // Nama Posyandu
            $table->string('desa');                    // Desa/Kelurahan
            $table->string('kecamatan');               // Kecamatan
            $table->string('kabupaten')->nullable();   // Kabupaten/Kota
            $table->string('alamat')->nullable();      // Alamat lengkap
            $table->string('kader_utama')->nullable(); // Nama kader utama
            $table->string('telepon', 15)->nullable(); // Nomor telepon
            $table->text('catatan')->nullable();       // Catatan tambahan
            $table->boolean('aktif')->default(true);   // Status aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandus');
    }
};
