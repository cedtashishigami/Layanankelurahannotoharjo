<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PotensiKelurahan extends Model
{
    protected $table = 'potensi_kelurahan';

    protected $primaryKey = 'id_potensi';

    protected $fillable = [
        'id_dusun',
        'id_user',
        'nama_potensi',
        'kategori',
        'pemilik',
        'deskripsi',
        'kontak',
        'foto',
        'lokasi',
    ];

    public function dusun(): BelongsTo
    {
        return $this->belongsTo(WilayahDusun::class, 'id_dusun', 'id_dusun');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
