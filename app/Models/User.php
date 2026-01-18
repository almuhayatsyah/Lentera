<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'posyandu_id',
        'nip',
        'telepon',
        'aktif',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'aktif' => 'boolean',
        ];
    }

    /**
     * Role constants
     */
    public const ROLE_ADMIN = 'admin_puskesmas';
    public const ROLE_KADER = 'kader';

    /**
     * Get posyandu assigned to this user
     */
    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Posyandu::class);
    }

    /**
     * Get all visits recorded by this user
     */
    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }

    /**
     * Check if user is admin puskesmas
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is kader
     */
    public function isKader(): bool
    {
        return $this->role === self::ROLE_KADER;
    }

    /**
     * Get role label for display
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'Admin Puskesmas',
            self::ROLE_KADER => 'Kader Posyandu',
            default => $this->role,
        };
    }

    /**
     * Get posyandu name or 'Semua Posyandu' for admin
     */
    public function getPosyanduNameAttribute(): string
    {
        if ($this->isAdmin()) {
            return 'Semua Posyandu';
        }
        return $this->posyandu?->nama ?? 'Belum Ditugaskan';
    }

    /**
     * Scope for active users only
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope for admin users
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    /**
     * Scope for kader users
     */
    public function scopeKader($query)
    {
        return $query->where('role', self::ROLE_KADER);
    }

    /**
     * Scope for users in specific posyandu
     */
    public function scopePosyandu($query, $posyanduId)
    {
        return $query->where('posyandu_id', $posyanduId);
    }

    /**
     * Get photo URL accessor
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }
}
