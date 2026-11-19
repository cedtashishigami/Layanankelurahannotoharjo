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

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_penduduk',
        'id_dusun',
        'name',
        'email',
        'nik',
        'no_hp',
        'password',
        'role',
        'jabatan',
        'foto',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk', 'id_penduduk');
    }

    public function dusun(): BelongsTo
    {
        return $this->belongsTo(WilayahDusun::class, 'id_dusun', 'id_dusun');
    }

    public function permohonanSurat(): HasMany
    {
        return $this->hasMany(PermohonanSurat::class, 'id_user', 'id_user');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'id_user', 'id_user');
    }

    public function layananPengaduan(): HasMany
    {
        return $this->hasMany(LayananPengaduan::class, 'id_user', 'id_user');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isLurah(): bool
    {
        return $this->role === 'lurah';
    }

    public function isSekretaris(): bool
    {
        return $this->role === 'sekretaris';
    }

    public function isKasiPelayanan(): bool
    {
        return $this->role === 'kasi_pelayanan';
    }

    public function isKadus(): bool
    {
        return $this->role === 'kadus';
    }

    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    public function isPegawai(): bool
    {
        return in_array($this->role, [
            'admin', 'lurah', 'sekretaris', 'kasi_pelayanan',
            'kasi_pemerintahan', 'kasi_kesra', 'kaur_keuangan',
            'kaur_umum', 'kadus',
        ]);
    }
}
