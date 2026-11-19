<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WilayahRt extends Model
{
    protected $table = 'wilayah_rt';

    protected $primaryKey = 'id_rt';

    protected $fillable = [
        'id_dusun',
        'nomor_rt',
        'nomor_rw',
        'nama_ketua_rt',
        'kontak_rt',
    ];

    public function dusun(): BelongsTo
    {
        return $this->belongsTo(WilayahDusun::class, 'id_dusun', 'id_dusun');
    }

    public function kartuKeluarga(): HasMany
    {
        return $this->hasMany(KartuKeluarga::class, 'id_rt', 'id_rt');
    }
}
