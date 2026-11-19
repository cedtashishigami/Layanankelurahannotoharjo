<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SyaratSurat extends Model
{
    protected $table = 'syarat_surat';

    protected $primaryKey = 'id_syarat_surat';

    protected $fillable = [
        'id_kode_surat',
        'nama_syarat',
        'is_wajib',
        'keterangan',
    ];

    protected $casts = [
        'is_wajib' => 'boolean',
    ];

    public function kodeSurat(): BelongsTo
    {
        return $this->belongsTo(KodeSurat::class, 'id_kode_surat', 'id_kode_surat');
    }

    public function lampiranPermohonan(): HasMany
    {
        return $this->hasMany(LampiranPermohonan::class, 'id_syarat_surat', 'id_syarat_surat');
    }
}
