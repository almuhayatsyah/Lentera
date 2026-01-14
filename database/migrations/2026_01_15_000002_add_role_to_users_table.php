<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add role and posyandu_id to users table for LENTERA
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin_puskesmas', 'kader'])->default('kader')->after('email');
            $table->foreignId('posyandu_id')->nullable()->after('role')->constrained('posyandus')->onDelete('set null');
            $table->string('nip')->nullable()->after('posyandu_id');      // NIP untuk petugas
            $table->string('telepon', 15)->nullable()->after('nip');       // Nomor telepon
            $table->boolean('aktif')->default(true)->after('telepon');     // Status aktif
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['posyandu_id']);
            $table->dropColumn(['role', 'posyandu_id', 'nip', 'telepon', 'aktif']);
        });
    }
};
