<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Satker extends Model
{
    protected $fillable = [
        'nama',
        'tingkatan',
        'wilayah',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Label tingkatan yang readable
     */
    public function getTingkatanLabelAttribute(): string
    {
        return match($this->tingkatan) {
            'pusat' => 'KPU Pusat',
            'provinsi' => 'KPU Provinsi',
            'kabupaten_kota' => 'KPU Kabupaten/Kota',
            default => $this->tingkatan,
        };
    }

    /**
     * Scope hanya satker aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope filter by tingkatan
     */
    public function scopeByTingkatan($query, $tingkatan)
    {
        return $query->where('tingkatan', $tingkatan);
    }
}