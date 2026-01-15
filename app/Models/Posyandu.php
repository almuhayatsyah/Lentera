<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Posyandu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'desa',
        'kecamatan',
        'kabupaten',
        'alamat',
        'latitude',
        'longitude',
        'kader_utama',
        'telepon',
        'catatan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get all users (kader) assigned to this posyandu
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all mothers registered at this posyandu
     */
    public function ibus(): HasMany
    {
        return $this->hasMany(Ibu::class);
    }

    /**
     * Get all children registered at this posyandu
     */
    public function anaks(): HasMany
    {
        return $this->hasMany(Anak::class);
    }

    /**
     * Get all visits at this posyandu
     */
    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }

    /**
     * Get full address
     */
    public function getAlamatLengkapAttribute(): string
    {
        $parts = array_filter([
            $this->alamat,
            $this->desa,
            $this->kecamatan,
            $this->kabupaten
        ]);
        return implode(', ', $parts);
    }

    /**
     * Scope for active posyandus only
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
