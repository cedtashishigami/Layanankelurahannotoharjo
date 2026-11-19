<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiPenduduk extends Model
{
    protected $table = 'mutasi_penduduk';

    protected $primaryKey = 'id_mutasi';

    protected $fillable = [
        'id_penduduk',
        'id_user',
        'jenis_mutasi',
        'tanggal_kejadian',
        'nomor_surat_keterangan',
        'alasan_tujuan',
        'file_berkas_bukti',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
    ];

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk', 'id_penduduk');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
