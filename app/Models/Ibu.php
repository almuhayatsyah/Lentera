<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Ibu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'rt',
        'rw',
        'desa',
        'telepon',
        'nama_suami',
        'pekerjaan',
        'posyandu_id',
        'aktif',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'aktif' => 'boolean',
    ];

    /**
     * Get posyandu where this mother is registered
     */
    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Posyandu::class);
    }

    /**
     * Get all children of this mother
     */
    public function anaks(): HasMany
    {
        return $this->hasMany(Anak::class);
    }

    /**
     * Get mother's age in years
     */
    public function getUsiaAttribute(): ?int
    {
        if (!$this->tanggal_lahir) {
            return null;
        }
        return $this->tanggal_lahir->age;
    }

    /**
     * Get formatted NIK (with spaces for readability)
     */
    public function getNikFormattedAttribute(): string
    {
        return chunk_split($this->nik, 4, ' ');
    }

    /**
     * Get full address with RT/RW
     */
    public function getAlamatLengkapAttribute(): string
    {
        $parts = [];
        if ($this->alamat) $parts[] = $this->alamat;
        if ($this->rt && $this->rw) $parts[] = "RT {$this->rt}/RW {$this->rw}";
        if ($this->desa) $parts[] = $this->desa;
        return implode(', ', $parts);
    }

    /**
     * Get number of children
     */
    public function getJumlahAnakAttribute(): int
    {
        return $this->anaks()->count();
    }

    /**
     * Scope for active mothers only
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope to search by name or NIK
     */
    public function scopeCari($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama', 'like', "%{$keyword}%")
              ->orWhere('nik', 'like', "%{$keyword}%");
        });
    }
}
