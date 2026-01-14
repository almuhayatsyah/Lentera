<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'anak_id',
        'posyandu_id',
        'user_id',
        'tanggal_kunjungan',
        'usia_bulan',
        'usia_hari',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    /**
     * Get the child for this visit
     */
    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class);
    }

    /**
     * Get the posyandu where visit took place
     */
    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Posyandu::class);
    }

    /**
     * Get the user (kader) who recorded this visit
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the measurement for this visit
     */
    public function pengukuran(): HasOne
    {
        return $this->hasOne(Pengukuran::class);
    }

    /**
     * Get the services/interventions for this visit
     */
    public function pelayanan(): HasOne
    {
        return $this->hasOne(Pelayanan::class);
    }

    /**
     * Get formatted date
     */
    public function getTanggalFormatAttribute(): string
    {
        return $this->tanggal_kunjungan->translatedFormat('d F Y');
    }

    /**
     * Get age formatted string at visit time
     */
    public function getUsiaFormatAttribute(): string
    {
        $years = intdiv($this->usia_bulan, 12);
        $months = $this->usia_bulan % 12;
        
        if ($years > 0) {
            return "{$years} thn {$months} bln";
        }
        return "{$months} bulan";
    }

    /**
     * Check if visit is complete (has measurement)
     */
    public function getIsCompleteAttribute(): bool
    {
        return $this->status === 'complete' && $this->pengukuran !== null;
    }

    /**
     * Scope for complete visits
     */
    public function scopeComplete($query)
    {
        return $query->where('status', 'complete');
    }

    /**
     * Scope by date range
     */
    public function scopeTanggal($query, $from, $to = null)
    {
        if ($to) {
            return $query->whereBetween('tanggal_kunjungan', [$from, $to]);
        }
        return $query->whereDate('tanggal_kunjungan', $from);
    }

    /**
     * Scope for this month
     */
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_kunjungan', now()->month)
                     ->whereYear('tanggal_kunjungan', now()->year);
    }

    /**
     * Scope for today
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_kunjungan', now());
    }
}
