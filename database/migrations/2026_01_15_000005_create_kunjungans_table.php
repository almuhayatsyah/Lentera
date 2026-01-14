<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Kunjungans - Tabel Transaksi Rutin (Visit Records)
     */
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anaks')->onDelete('cascade');
            $table->foreignId('posyandu_id')->constrained('posyandus')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');  // Petugas yang input
            $table->date('tanggal_kunjungan');                   // Tanggal kunjungan
            $table->integer('usia_bulan');                       // Usia dalam bulan saat kunjungan
            $table->integer('usia_hari')->nullable();            // Usia dalam hari (lebih presisi)
            $table->text('catatan')->nullable();                 // Catatan kunjungan
            $table->enum('status', ['draft', 'complete'])->default('complete');
            $table->timestamps();

            $table->index('tanggal_kunjungan');
            $table->index(['anak_id', 'tanggal_kunjungan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
