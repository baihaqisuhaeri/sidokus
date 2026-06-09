<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubKategoriBerkas extends Model
{
    protected $table = 'sub_kategori_berkas';

    protected $fillable = [
        'kategori_id',
        'nama',
        'has_nomor_surat',
        'urutan',
    ];

    protected $casts = [
        'has_nomor_surat' => 'boolean',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBerkas::class, 'kategori_id');
    }

    public function berkas(): HasMany
    {
        return $this->hasMany(Berkas::class, 'sub_kategori_id');
    }
}