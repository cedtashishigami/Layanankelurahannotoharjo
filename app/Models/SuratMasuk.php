<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';

    protected $primaryKey = 'id_surat_masuk';

    protected $fillable = [
        'id_user',
        'nomor_surat',
        'nomor_agenda_masuk',
        'tanggal_surat',
        'tanggal_diterima',
        'pengirim',
        'perihal',
        'file_arsip',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
