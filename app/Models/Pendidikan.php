<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendidikan extends Model
{
    protected $table = 'pendidikan';

    protected $primaryKey = 'id_pendidikan';

    protected $fillable = [
        'nama_pendidikan',
        'is_delete',
    ];

    protected $casts = [
        'is_delete' => 'boolean',
    ];

    public function penduduk(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'id_pendidikan', 'id_pendidikan');
    }
}
