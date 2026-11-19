<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LampiranPermohonan extends Model
{
    protected $table = 'lampiran_permohonan';

    protected $primaryKey = 'id_lampiran';

    protected $fillable = [
        'id_permohonan_surat',
        'id_syarat_surat',
        'nama_file',
        'file_path',
        'status_validasi',
        'catatan',
    ];

    public function permohonanSurat(): BelongsTo
    {
        return $this->belongsTo(PermohonanSurat::class, 'id_permohonan_surat', 'id_permohonan_surat');
    }

    public function syaratSurat(): BelongsTo
    {
        return $this->belongsTo(SyaratSurat::class, 'id_syarat_surat', 'id_syarat_surat');
    }
}
