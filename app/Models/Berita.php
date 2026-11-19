<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';

    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'id_user',
        'judul',
        'slug',
        'ringkasan',
        'isi_berita',
        'gambar',
        'status',
        'views',
    ];

    protected static function booted(): void
    {
        static::creating(function (Berita $berita): void {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
