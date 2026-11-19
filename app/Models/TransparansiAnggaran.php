<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransparansiAnggaran extends Model
{
    protected $table = 'transparansi_anggaran';

    protected $primaryKey = 'id_anggaran';

    protected $fillable = [
        'id_user',
        'tahun_anggaran',
        'jenis',
        'bidang',
        'uraian',
        'target_anggaran',
        'realisasi_anggaran',
        'keterangan',
    ];

    protected $casts = [
        'target_anggaran' => 'decimal:2',
        'realisasi_anggaran' => 'decimal:2',
    ];

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
