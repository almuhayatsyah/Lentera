<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pelayanans - Inti Data Nutrisi/Intervensi
     * Vitamin A, Obat Cacing, Imunisasi, PMT
     */
    public function up(): void
    {
        Schema::create('pelayanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade');
            
            // Vitamin A
            $table->boolean('vitamin_a')->default(false);
            $table->enum('vitamin_a_dosis', ['biru', 'merah'])->nullable(); // Biru (6-11 bln), Merah (12-59 bln)
            $table->date('vitamin_a_tanggal')->nullable();
            
            // Obat Cacing
            $table->boolean('obat_cacing')->default(false);
            $table->date('obat_cacing_tanggal')->nullable();
            
            // Imunisasi
            $table->json('imunisasi')->nullable();  // Array: ['BCG', 'Polio 1', 'DPT 1', etc.]
            
            // PMT (Pemberian Makanan Tambahan)
            $table->boolean('pmt')->default(false);
            $table->string('jenis_pmt')->nullable();        // Jenis PMT yang diberikan
            $table->integer('jumlah_pmt')->nullable();      // Jumlah PMT
            $table->string('satuan_pmt')->nullable();       // Satuan (paket, porsi, kg)
            
            // ASI Eksklusif (untuk bayi < 6 bulan)
            $table->boolean('asi_eksklusif')->nullable();
            
            // Konseling
            $table->boolean('konseling_gizi')->default(false);
            $table->text('materi_konseling')->nullable();
            
            // MTBS (Manajemen Terpadu Balita Sakit)
            $table->boolean('rujuk_mtbs')->default(false);
            $table->text('keterangan_mtbs')->nullable();
            
            $table->text('keterangan')->nullable();         // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelayanans');
    }
};
