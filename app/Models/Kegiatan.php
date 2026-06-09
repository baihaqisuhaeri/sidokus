<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kegiatan extends Model
{
    protected $fillable = [
        'judul',
        'tanggal',
        'jenis_kegiatan',
        'lokasi',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function fotos(): HasMany
    {
        return $this->hasMany(KegiatanFoto::class)->orderBy('urutan');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFotoUtamaAttribute()
    {
        return $this->fotos->first();
    }
}
