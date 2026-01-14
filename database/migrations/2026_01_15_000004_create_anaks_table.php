<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Anaks - Data Anak (Sasaran Tumbuh Kembang)
     */
    public function up(): void
    {
        Schema::create('anaks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');                              // Nama anak
            $table->string('nik', 16)->nullable()->unique();     // NIK anak (jika ada)
            $table->enum('jenis_kelamin', ['L', 'P']);           // L=Laki-laki, P=Perempuan
            $table->date('tanggal_lahir');                       // Tanggal lahir
            $table->string('tempat_lahir')->nullable();          // Tempat lahir
            $table->foreignId('ibu_id')->constrained('ibus')->onDelete('cascade');
            $table->foreignId('posyandu_id')->constrained('posyandus')->onDelete('cascade');
            $table->integer('urutan_anak')->default(1);          // Anak ke-berapa
            $table->decimal('berat_lahir', 4, 2)->nullable();    // BB lahir (kg)
            $table->decimal('panjang_lahir', 5, 2)->nullable();  // PB lahir (cm)
            $table->decimal('lingkar_kepala_lahir', 4, 1)->nullable(); // LK lahir (cm)
            $table->string('golongan_darah', 3)->nullable();     // Golongan darah
            $table->text('catatan')->nullable();                 // Catatan khusus
            $table->boolean('aktif')->default(true);             // Status aktif
            $table->timestamps();

            $table->index('nama');
            $table->index('tanggal_lahir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anaks');
    }
};
