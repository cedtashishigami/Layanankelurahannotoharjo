<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penduduk extends Model
{
    protected $table = 'penduduk';

    protected $primaryKey = 'id_penduduk';

    protected $fillable = [
        'id_kartu_keluarga',
        'id_pekerjaan',
        'id_pendidikan',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_kawin',
        'status_hubungan_keluarga',
        'kewarganegaraan',
        'nama_ayah',
        'nama_ibu',
        'no_telepon',
        'status_keberadaan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class, 'id_kartu_keluarga', 'id_kartu_keluarga');
    }

    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class, 'id_pekerjaan', 'id_pekerjaan');
    }

    public function pendidikan(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class, 'id_pendidikan', 'id_pendidikan');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_penduduk', 'id_penduduk');
    }

    public function mutasiPenduduk(): HasMany
    {
        return $this->hasMany(MutasiPenduduk::class, 'id_penduduk', 'id_penduduk');
    }

    public function permohonanSurat(): HasMany
    {
        return $this->hasMany(PermohonanSurat::class, 'id_penduduk', 'id_penduduk');
    }
}
