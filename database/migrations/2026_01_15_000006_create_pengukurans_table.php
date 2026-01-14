<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pengukurans - Inti Data Tumbuh Kembang (Growth Measurements)
     * BB, TB, LK, dan Status Gizi (auto-calculated)
     */
    public function up(): void
    {
        Schema::create('pengukurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade');
            
            // Data Antropometri
            $table->decimal('berat_badan', 5, 2);              // BB dalam kg (max 999.99)
            $table->decimal('tinggi_badan', 5, 2);             // TB dalam cm (max 999.99)
            $table->decimal('lingkar_kepala', 4, 1)->nullable(); // LK dalam cm
            $table->decimal('lingkar_lengan', 4, 1)->nullable(); // LILA dalam cm
            
            // Z-Scores (auto-calculated by system)
            $table->decimal('zscore_bb_u', 5, 2)->nullable();  // BB/U (Weight-for-Age)
            $table->decimal('zscore_tb_u', 5, 2)->nullable();  // TB/U (Height-for-Age)
            $table->decimal('zscore_bb_tb', 5, 2)->nullable(); // BB/TB (Weight-for-Height)
            $table->decimal('zscore_imt_u', 5, 2)->nullable(); // IMT/U (BMI-for-Age)
            
            // Status Gizi Berdasarkan BB/U
            $table->enum('status_gizi', [
                'gizi_buruk',      // < -3 SD (Severely underweight)
                'gizi_kurang',     // -3 SD s/d < -2 SD (Underweight)
                'gizi_baik',       // -2 SD s/d +2 SD (Normal)
                'gizi_lebih',      // > +2 SD (Overweight)
            ])->default('gizi_baik');
            
            // Status Stunting Berdasarkan TB/U
            $table->enum('status_stunting', [
                'sangat_pendek',   // < -3 SD (Severely stunted)
                'pendek',          // -3 SD s/d < -2 SD (Stunted)
                'normal',          // -2 SD s/d +2 SD (Normal height)
                'tinggi',          // > +2 SD (Tall)
            ])->default('normal');
            
            // Status Wasting Berdasarkan BB/TB
            $table->enum('status_wasting', [
                'gizi_buruk_akut', // < -3 SD (Severe wasting)
                'gizi_kurang_akut',// -3 SD s/d < -2 SD (Wasting)
                'normal',          // -2 SD s/d +2 SD (Normal)
                'berisiko_lebih',  // > +2 SD (Overweight risk)
                'obesitas',        // > +3 SD (Obese)
            ])->default('normal');
            
            // Kenaikan BB dari kunjungan sebelumnya
            $table->boolean('naik_berat_badan')->nullable();   // Apakah BB naik?
            $table->string('keterangan_bb')->nullable();       // N, T, O, B (Naik, Tidak naik, dll)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengukurans');
    }
};
