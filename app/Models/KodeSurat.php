<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KodeSurat extends Model
{
    protected $table = 'kode_surat';

    protected $primaryKey = 'id_kode_surat';

    protected $fillable = [
        'kode_klasifikasi',
        'nama_surat',
        'template_view',
        'masa_berlaku_hari',
        'deskripsi',
    ];

    public function syaratSurat(): HasMany
    {
        return $this->hasMany(SyaratSurat::class, 'id_kode_surat', 'id_kode_surat');
    }

    public function permohonanSurat(): HasMany
    {
        return $this->hasMany(PermohonanSurat::class, 'id_kode_surat', 'id_kode_surat');
    }
}
