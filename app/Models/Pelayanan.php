<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kunjungan_id',
        'vitamin_a',
        'vitamin_a_dosis',
        'vitamin_a_tanggal',
        'obat_cacing',
        'obat_cacing_tanggal',
        'imunisasi',
        'pmt',
        'jenis_pmt',
        'jumlah_pmt',
        'satuan_pmt',
        'asi_eksklusif',
        'konseling_gizi',
        'materi_konseling',
        'rujuk_mtbs',
        'keterangan_mtbs',
        'keterangan',
    ];

    protected $casts = [
        'vitamin_a' => 'boolean',
        'vitamin_a_tanggal' => 'date',
        'obat_cacing' => 'boolean',
        'obat_cacing_tanggal' => 'date',
        'imunisasi' => 'array',
        'pmt' => 'boolean',
        'asi_eksklusif' => 'boolean',
        'konseling_gizi' => 'boolean',
        'rujuk_mtbs' => 'boolean',
    ];

    // Available immunizations
    public const DAFTAR_IMUNISASI = [
        'HB-0' => 'Hepatitis B (0-7 hari)',
        'BCG' => 'BCG',
        'Polio 1' => 'Polio 1',
        'Polio 2' => 'Polio 2',
        'Polio 3' => 'Polio 3',
        'Polio 4' => 'Polio 4',
        'DPT-HB-Hib 1' => 'DPT-HB-Hib 1',
        'DPT-HB-Hib 2' => 'DPT-HB-Hib 2',
        'DPT-HB-Hib 3' => 'DPT-HB-Hib 3',
        'IPV' => 'IPV',
        'Campak/MR 1' => 'Campak/MR 1',
        'Campak/MR 2' => 'Campak/MR 2',
        'DPT-HB-Hib Lanjutan' => 'DPT-HB-Hib Lanjutan',
    ];

    // PMT Types
    public const JENIS_PMT = [
        'biskuit' => 'Biskuit MT',
        'susu' => 'Susu Formula',
        'makanan_lokal' => 'Makanan Lokal',
        'bubur' => 'Bubur Kacang Hijau',
        'telur' => 'Telur',
        'lainnya' => 'Lainnya',
    ];

    /**
     * Get the visit this service belongs to
     */
    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }

    /**
     * Get vitamin A dose label
     */
    public function getDosisVitaminALabelAttribute(): ?string
    {
        if (!$this->vitamin_a) {
            return null;
        }
        return $this->vitamin_a_dosis === 'biru' 
            ? 'Kapsul Biru (100.000 IU)' 
            : 'Kapsul Merah (200.000 IU)';
    }

    /**
     * Get list of immunizations given as string
     */
    public function getImunisasiListAttribute(): string
    {
        if (empty($this->imunisasi)) {
            return '-';
        }
        return implode(', ', $this->imunisasi);
    }

    /**
     * Get PMT description
     */
    public function getPmtDescriptionAttribute(): ?string
    {
        if (!$this->pmt) {
            return null;
        }
        $parts = [];
        if ($this->jenis_pmt) {
            $parts[] = self::JENIS_PMT[$this->jenis_pmt] ?? $this->jenis_pmt;
        }
        if ($this->jumlah_pmt && $this->satuan_pmt) {
            $parts[] = "{$this->jumlah_pmt} {$this->satuan_pmt}";
        }
        return implode(' - ', $parts);
    }

    /**
     * Check if any intervention was given
     */
    public function getHasIntervensiAttribute(): bool
    {
        return $this->vitamin_a 
            || $this->obat_cacing 
            || !empty($this->imunisasi) 
            || $this->pmt;
    }

    /**
     * Get summary of services given
     */
    public function getSummaryAttribute(): array
    {
        $summary = [];
        
        if ($this->vitamin_a) {
            $summary[] = 'Vitamin A';
        }
        if ($this->obat_cacing) {
            $summary[] = 'Obat Cacing';
        }
        if (!empty($this->imunisasi)) {
            $summary[] = 'Imunisasi (' . count($this->imunisasi) . ')';
        }
        if ($this->pmt) {
            $summary[] = 'PMT';
        }
        if ($this->konseling_gizi) {
            $summary[] = 'Konseling';
        }
        if ($this->rujuk_mtbs) {
            $summary[] = 'Rujuk MTBS';
        }
        
        return $summary;
    }

    /**
     * Scope for visits with vitamin A given
     */
    public function scopeVitaminA($query)
    {
        return $query->where('vitamin_a', true);
    }

    /**
     * Scope for visits with PMT given
     */
    public function scopePmt($query)
    {
        return $query->where('pmt', true);
    }

    /**
     * Scope for visits with immunization
     */
    public function scopeImunisasi($query)
    {
        return $query->whereNotNull('imunisasi');
    }
}
