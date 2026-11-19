<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PermohonanSurat extends Model
{
    protected $table = 'permohonan_surat';

    protected $primaryKey = 'id_permohonan_surat';

    protected $fillable = [
        'id_user',
        'id_penduduk',
        'id_kode_surat',
        'nomor_surat',
        'tanggal_pengajuan',
        'keperluan',
        'keterangan_tambahan',
        'status',
        'token_qr',
        'file_pdf',
        'tanggal_disahkan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_disahkan' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (PermohonanSurat $permohonan): void {
            if (empty($permohonan->token_qr)) {
                $permohonan->token_qr = Str::uuid()->toString();
            }
        });
    }

    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk', 'id_penduduk');
    }

    public function kodeSurat(): BelongsTo
    {
        return $this->belongsTo(KodeSurat::class, 'id_kode_surat', 'id_kode_surat');
    }

    public function lampiranPermohonan(): HasMany
    {
        return $this->hasMany(LampiranPermohonan::class, 'id_permohonan_surat', 'id_permohonan_surat');
    }

    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatusSurat::class, 'id_permohonan_surat', 'id_permohonan_surat');
    }
}
