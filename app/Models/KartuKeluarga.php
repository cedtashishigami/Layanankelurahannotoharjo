<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluarga';

    protected $primaryKey = 'id_kartu_keluarga';

    protected $fillable = [
        'id_rt',
        'nomor_kk',
        'nama_kepala_keluarga',
        'alamat_lengkap',
        'kode_pos',
    ];

    public function rt(): BelongsTo
    {
        return $this->belongsTo(WilayahRt::class, 'id_rt', 'id_rt');
    }

    public function penduduk(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'id_kartu_keluarga', 'id_kartu_keluarga');
    }
}
