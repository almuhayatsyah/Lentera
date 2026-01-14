<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Carbon\Carbon;

class Anak extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'ibu_id',
        'posyandu_id',
        'urutan_anak',
        'berat_lahir',
        'panjang_lahir',
        'lingkar_kepala_lahir',
        'golongan_darah',
        'catatan',
        'aktif',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'berat_lahir' => 'decimal:2',
        'panjang_lahir' => 'decimal:2',
        'lingkar_kepala_lahir' => 'decimal:1',
        'aktif' => 'boolean',
    ];

    /**
     * Get the mother of this child
     */
    public function ibu(): BelongsTo
    {
        return $this->belongsTo(Ibu::class);
    }

    /**
     * Get the posyandu where this child is registered
     */
    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Posyandu::class);
    }

    /**
     * Get all visits for this child
     */
    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }

    /**
     * Get all measurements through visits
     */
    public function pengukurans(): HasManyThrough
    {
        return $this->hasManyThrough(Pengukuran::class, Kunjungan::class);
    }

    /**
     * Get age in months
     */
    public function getUsiaBulanAttribute(): int
    {
        return $this->tanggal_lahir->diffInMonths(Carbon::now());
    }

    /**
     * Get age in days (for more precise calculations)
     */
    public function getUsiaHariAttribute(): int
    {
        return $this->tanggal_lahir->diffInDays(Carbon::now());
    }

    /**
     * Get formatted age string (e.g., "2 tahun 3 bulan")
     */
    public function getUsiaFormatAttribute(): string
    {
        $now = Carbon::now();
        $years = (int) floor($this->tanggal_lahir->floatDiffInYears($now));
        $months = (int) floor($this->tanggal_lahir->copy()->addYears($years)->floatDiffInMonths($now));
        
        if ($years > 0) {
            return "{$years} tahun {$months} bulan";
        }
        return "{$months} bulan";
    }

    /**
     * Get gender in full text
     */
    public function getJenisKelaminTextAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    /**
     * Check if child is still under 5 years old (balita)
     */
    public function getIsBalitaAttribute(): bool
    {
        return $this->usia_bulan < 60; // Under 60 months = under 5 years
    }

    /**
     * Check if child is infant (under 1 year)
     */
    public function getIsBayiAttribute(): bool
    {
        return $this->usia_bulan < 12;
    }

    /**
     * Get latest measurement
     */
    public function getPengukuranTerakhirAttribute(): ?Pengukuran
    {
        return $this->pengukurans()->latest()->first();
    }

    /**
     * Get latest visit
     */
    public function getKunjunganTerakhirAttribute(): ?Kunjungan
    {
        return $this->kunjungans()->latest('tanggal_kunjungan')->first();
    }

    /**
     * Get current nutritional status
     */
    public function getStatusGiziTerakhirAttribute(): ?string
    {
        $pengukuran = $this->pengukuran_terakhir;
        return $pengukuran?->status_gizi;
    }

    /**
     * Get current stunting status
     */
    public function getStatusStuntingTerakhirAttribute(): ?string
    {
        $pengukuran = $this->pengukuran_terakhir;
        return $pengukuran?->status_stunting;
    }

    /**
     * Scope for active children only
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope for balita (under 5 years)
     */
    public function scopeBalita($query)
    {
        return $query->where('tanggal_lahir', '>=', Carbon::now()->subYears(5));
    }

    /**
     * Scope to search by name
     */
    public function scopeCari($query, $keyword)
    {
        return $query->where('nama', 'like', "%{$keyword}%");
    }

    /**
     * Scope by gender
     */
    public function scopeJenisKelamin($query, $jk)
    {
        return $query->where('jenis_kelamin', $jk);
    }
}
