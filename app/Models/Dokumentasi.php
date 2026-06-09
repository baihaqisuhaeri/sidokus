<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    //
    protected $table = 'dokumentasi';

     protected $fillable = [
        'judul',
        'jenis_pemilu',
        'jenis_surat_suara',  // ← Tambah ini
        'tahun',
        'file',
        'keterangan',
    ];

    protected $casts = [
    'jenis_surat_suara' => 'string',
];
}
