<?php

namespace Database\Seeders;

use App\Models\KategoriBerkas;
use App\Models\SubKategoriBerkas;
use Illuminate\Database\Seeder;

class KategoriBerkasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Administrasi Internal',
                'urutan' => 1,
                'sub' => [
                    ['nama' => 'Nota Dinas (ND)', 'has_nomor_surat' => true, 'urutan' => 1],
                    ['nama' => 'Undangan', 'has_nomor_surat' => true, 'urutan' => 2],
                    ['nama' => 'Surat Tugas (ST)', 'has_nomor_surat' => true, 'urutan' => 3],
                ],
            ],
            [
                'nama' => 'Administrasi Eksternal',
                'urutan' => 2,
                'sub' => [
                    ['nama' => 'Nota Dinas (ND)', 'has_nomor_surat' => true, 'urutan' => 1],
                    ['nama' => 'Undangan', 'has_nomor_surat' => true, 'urutan' => 2],
                    ['nama' => 'Surat Tugas (ST)', 'has_nomor_surat' => true, 'urutan' => 3],
                ],
            ],
            [
                'nama' => 'Administrasi Pengadaan',
                'urutan' => 3,
                'sub' => [
                    ['nama' => 'Nota Dinas (ND)', 'has_nomor_surat' => true, 'urutan' => 1],
                    ['nama' => 'Berita Acara HPS (BA HPS)', 'has_nomor_surat' => true, 'urutan' => 2],
                    ['nama' => 'Kerangka Acuan Kerja (KAK)', 'has_nomor_surat' => false, 'urutan' => 3],
                    ['nama' => 'Dokumen Pendukung', 'has_nomor_surat' => false, 'urutan' => 4],
                ],
            ],
            [
                'nama' => 'Dokumen Kegiatan',
                'urutan' => 4,
                'sub' => [
                    ['nama' => 'Daftar Hadir', 'has_nomor_surat' => false, 'urutan' => 1],
                    ['nama' => 'Tanda Terima', 'has_nomor_surat' => false, 'urutan' => 2],
                    ['nama' => 'Pembagian Tugas', 'has_nomor_surat' => false, 'urutan' => 3],
                    ['nama' => 'Roomlist', 'has_nomor_surat' => false, 'urutan' => 4],
                    ['nama' => 'Dokumen Lainnya', 'has_nomor_surat' => false, 'urutan' => 5],
                ],
            ],
            [
                'nama' => 'Honorarium Narasumber',
                'urutan' => 5,
                'sub' => [
                    ['nama' => 'SK Narasumber', 'has_nomor_surat' => true, 'urutan' => 1],
                    ['nama' => 'Undangan Narasumber', 'has_nomor_surat' => true, 'urutan' => 2],
                    ['nama' => 'Normatif', 'has_nomor_surat' => false, 'urutan' => 3],
                    ['nama' => 'Biodata', 'has_nomor_surat' => false, 'urutan' => 4],
                    ['nama' => 'NPWP', 'has_nomor_surat' => false, 'urutan' => 5],
                    ['nama' => 'Nomor Rekening', 'has_nomor_surat' => false, 'urutan' => 6],
                    ['nama' => 'Materi (PPT)', 'has_nomor_surat' => false, 'urutan' => 7],
                ],
            ],
        ];

        foreach ($data as $kategoriData) {
            $subs = $kategoriData['sub'];
            unset($kategoriData['sub']);

            $kategori = KategoriBerkas::create($kategoriData);

            foreach ($subs as $sub) {
                SubKategoriBerkas::create([
                    'kategori_id' => $kategori->id,
                    ...$sub,
                ]);
            }
        }
    }
}
