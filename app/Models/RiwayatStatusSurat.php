<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatStatusSurat extends Model
{
    protected $table = 'riwayat_status_surat';

    protected $primaryKey = 'id_riwayat_surat';

    protected $fillable = [
        'id_permohonan_surat',
        'id_user',
        'tahapan',
        'status_tahap',
        'catatan_petugas',
    ];

    public function permohonanSurat(): BelongsTo
    {
        return $this->belongsTo(PermohonanSurat::class, 'id_permohonan_surat', 'id_permohonan_surat');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
