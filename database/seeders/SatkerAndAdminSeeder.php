<?php

namespace Database\Seeders;

use App\Models\Satker;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SatkerAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Satker Pusat
        $pusat = Satker::create([
            'nama' => 'KPU Pusat',
            'tingkatan' => 'pusat',
            'wilayah' => null,
        ]);

        // Satker Provinsi (contoh beberapa)
        $provinsi = [
            'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur',
            'Banten', 'DI Yogyakarta', 'Sumatera Utara', 'Sumatera Selatan',
            'Kalimantan Timur', 'Sulawesi Selatan', 'Bali', 'Papua',
        ];
        foreach ($provinsi as $prov) {
            Satker::create([
                'nama' => "KPU Provinsi $prov",
                'tingkatan' => 'provinsi',
                'wilayah' => $prov,
            ]);
        }

        // Satker Kabupaten/Kota (contoh beberapa)
        $kabkota = [
            ['nama' => 'KPU Kota Jakarta Pusat', 'wilayah' => 'Jakarta Pusat'],
            ['nama' => 'KPU Kota Bandung', 'wilayah' => 'Kota Bandung'],
            ['nama' => 'KPU Kabupaten Bogor', 'wilayah' => 'Kab. Bogor'],
            ['nama' => 'KPU Kota Surabaya', 'wilayah' => 'Kota Surabaya'],
            ['nama' => 'KPU Kota Semarang', 'wilayah' => 'Kota Semarang'],
            ['nama' => 'KPU Kota Depok', 'wilayah' => 'Kota Depok'],
        ];
        foreach ($kabkota as $kk) {
            Satker::create([
                'nama' => $kk['nama'],
                'tingkatan' => 'kabupaten_kota',
                'wilayah' => $kk['wilayah'],
            ]);
        }

        // Buat akun Admin default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sidokus.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'satker_id' => $pusat->id,
            'jabatan' => 'Administrator Sistem',
        ]);
    }
}
