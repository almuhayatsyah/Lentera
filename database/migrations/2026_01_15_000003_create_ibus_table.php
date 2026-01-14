<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ibus - Data Ibu (dengan NIK sebagai unique identifier)
     */
    public function up(): void
    {
        Schema::create('ibus', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();           // NIK unik
            $table->string('nama');                         // Nama lengkap ibu
            $table->date('tanggal_lahir')->nullable();      // Tanggal lahir
            $table->string('tempat_lahir')->nullable();     // Tempat lahir
            $table->text('alamat')->nullable();             // Alamat lengkap
            $table->string('rt', 5)->nullable();            // RT
            $table->string('rw', 5)->nullable();            // RW
            $table->string('desa')->nullable();             // Desa/Kelurahan
            $table->string('telepon', 15)->nullable();      // Nomor telepon
            $table->string('nama_suami')->nullable();       // Nama suami/ayah
            $table->string('pekerjaan')->nullable();        // Pekerjaan
            $table->foreignId('posyandu_id')->constrained('posyandus')->onDelete('cascade');
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->index('nik');
            $table->index('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibus');
    }
};
