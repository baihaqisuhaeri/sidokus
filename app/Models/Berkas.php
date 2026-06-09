<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berkas extends Model
{
    protected $table = 'berkas';

    protected $fillable = [
        'judul',
        'sub_kategori_id',
        'nomor_surat',
        'tahun',
        'file',
        'keterangan',
        'user_id',
    ];

    public function subKategori(): BelongsTo
    {
        return $this->belongsTo(SubKategoriBerkas::class, 'sub_kategori_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getExtensionAttribute(): string
    {
        return strtolower(pathinfo($this->file, PATHINFO_EXTENSION));
    }

    public function getIsImageAttribute(): bool
    {
        return in_array($this->extension, ['jpg', 'jpeg', 'png', 'gif']);
    }

    public function getIsPdfAttribute(): bool
    {
        return $this->extension === 'pdf';
    }

    public function getKategoriNamaAttribute(): string
    {
        return $this->subKategori?->kategori?->nama ?? '—';
    }
}