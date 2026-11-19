<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WilayahDusun extends Model
{
    protected $table = 'wilayah_dusun';

    protected $primaryKey = 'id_dusun';

    protected $fillable = [
        'nama_dusun',
        'nama_kadus',
        'kontak_kadus',
        'keterangan',
    ];

    public function wilayahRt(): HasMany
    {
        return $this->hasMany(WilayahRt::class, 'id_dusun', 'id_dusun');
    }

    public function potensiKelurahan(): HasMany
    {
        return $this->hasMany(PotensiKelurahan::class, 'id_dusun', 'id_dusun');
    }

    public function layananPengaduan(): HasMany
    {
        return $this->hasMany(LayananPengaduan::class, 'id_dusun', 'id_dusun');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_dusun', 'id_dusun');
    }
}
