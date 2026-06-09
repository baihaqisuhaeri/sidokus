<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBerkas extends Model
{
    protected $table = 'kategori_berkas';

    protected $fillable = ['nama', 'urutan'];

    public function subKategoris(): HasMany
    {
        return $this->hasMany(SubKategoriBerkas::class, 'kategori_id')->orderBy('urutan');
    }
}