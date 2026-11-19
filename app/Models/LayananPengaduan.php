<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayananPengaduan extends Model
{
    protected $table = 'layanan_pengaduan';

    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'id_user',
        'id_dusun',
        'judul_laporan',
        'kategori',
        'isi_laporan',
        'foto_bukti',
        'status',
        'tanggapan_petugas',
        'tanggal_tanggapan',
    ];

    protected $casts = [
        'tanggal_tanggapan' => 'datetime',
    ];

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function dusun(): BelongsTo
    {
        return $this->belongsTo(WilayahDusun::class, 'id_dusun', 'id_dusun');
    }
}
