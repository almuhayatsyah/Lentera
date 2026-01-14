<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengukuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kunjungan_id',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lingkar_lengan',
        'zscore_bb_u',
        'zscore_tb_u',
        'zscore_bb_tb',
        'zscore_imt_u',
        'status_gizi',
        'status_stunting',
        'status_wasting',
        'naik_berat_badan',
        'keterangan_bb',
    ];

    protected $casts = [
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'lingkar_kepala' => 'decimal:1',
        'lingkar_lengan' => 'decimal:1',
        'zscore_bb_u' => 'decimal:2',
        'zscore_tb_u' => 'decimal:2',
        'zscore_bb_tb' => 'decimal:2',
        'zscore_imt_u' => 'decimal:2',
        'naik_berat_badan' => 'boolean',
    ];

    // Status labels for display
    public const STATUS_GIZI_LABELS = [
        'gizi_buruk' => 'Gizi Buruk',
        'gizi_kurang' => 'Gizi Kurang',
        'gizi_baik' => 'Gizi Baik',
        'gizi_lebih' => 'Gizi Lebih',
    ];

    public const STATUS_STUNTING_LABELS = [
        'sangat_pendek' => 'Sangat Pendek (Stunting Berat)',
        'pendek' => 'Pendek (Stunting)',
        'normal' => 'Normal',
        'tinggi' => 'Tinggi',
    ];

    public const STATUS_WASTING_LABELS = [
        'gizi_buruk_akut' => 'Gizi Buruk Akut (Wasting Berat)',
        'gizi_kurang_akut' => 'Gizi Kurang Akut (Wasting)',
        'normal' => 'Normal',
        'berisiko_lebih' => 'Berisiko Gizi Lebih',
        'obesitas' => 'Obesitas',
    ];

    // Color codes for status badges
    public const STATUS_GIZI_COLORS = [
        'gizi_buruk' => 'danger',
        'gizi_kurang' => 'warning',
        'gizi_baik' => 'success',
        'gizi_lebih' => 'info',
    ];

    public const STATUS_STUNTING_COLORS = [
        'sangat_pendek' => 'danger',
        'pendek' => 'warning',
        'normal' => 'success',
        'tinggi' => 'info',
    ];

    /**
     * Get the visit this measurement belongs to
     */
    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }

    /**
     * Get the child through visit
     */
    public function getAnakAttribute()
    {
        return $this->kunjungan?->anak;
    }

    /**
     * Get status gizi label
     */
    public function getStatusGiziLabelAttribute(): string
    {
        return self::STATUS_GIZI_LABELS[$this->status_gizi] ?? $this->status_gizi;
    }

    /**
     * Get status stunting label
     */
    public function getStatusStuntingLabelAttribute(): string
    {
        return self::STATUS_STUNTING_LABELS[$this->status_stunting] ?? $this->status_stunting;
    }

    /**
     * Get status wasting label
     */
    public function getStatusWastingLabelAttribute(): string
    {
        return self::STATUS_WASTING_LABELS[$this->status_wasting] ?? $this->status_wasting;
    }

    /**
     * Get status gizi badge color
     */
    public function getStatusGiziColorAttribute(): string
    {
        return self::STATUS_GIZI_COLORS[$this->status_gizi] ?? 'secondary';
    }

    /**
     * Get status stunting badge color
     */
    public function getStatusStuntingColorAttribute(): string
    {
        return self::STATUS_STUNTING_COLORS[$this->status_stunting] ?? 'secondary';
    }

    /**
     * Calculate BMI (Body Mass Index)
     */
    public function getImtAttribute(): ?float
    {
        if (!$this->berat_badan || !$this->tinggi_badan) {
            return null;
        }
        $heightInMeters = $this->tinggi_badan / 100;
        return round($this->berat_badan / ($heightInMeters * $heightInMeters), 2);
    }

    /**
     * Check if stunting (short or very short)
     */
    public function getIsStuntingAttribute(): bool
    {
        return in_array($this->status_stunting, ['sangat_pendek', 'pendek']);
    }

    /**
     * Check if underweight
     */
    public function getIsUnderweightAttribute(): bool
    {
        return in_array($this->status_gizi, ['gizi_buruk', 'gizi_kurang']);
    }

    /**
     * Check if wasting
     */
    public function getIsWastingAttribute(): bool
    {
        return in_array($this->status_wasting, ['gizi_buruk_akut', 'gizi_kurang_akut']);
    }

    /**
     * Scope for stunting cases
     */
    public function scopeStunting($query)
    {
        return $query->whereIn('status_stunting', ['sangat_pendek', 'pendek']);
    }

    /**
     * Scope for underweight cases
     */
    public function scopeUnderweight($query)
    {
        return $query->whereIn('status_gizi', ['gizi_buruk', 'gizi_kurang']);
    }

    /**
     * Scope for normal status
     */
    public function scopeNormal($query)
    {
        return $query->where('status_gizi', 'gizi_baik')
                     ->where('status_stunting', 'normal');
    }
}
