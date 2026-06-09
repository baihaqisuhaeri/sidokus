<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\KegiatanFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::with('fotos')->withCount('fotos');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $request->jenis_kegiatan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $kegiatans = $query->latest('tanggal')->paginate(9);

        $jenisKegiatan = [
            'Rapat', 'Sosialisasi', 'Pelatihan', 'Bimbingan Teknis',
            'Monitoring', 'Evaluasi', 'Pelantikan', 'Lainnya'
        ];

        return view('kegiatan.index', compact('kegiatans', 'jenisKegiatan'));
    }

    public function create()
    {
        $jenisKegiatan = [
            'Rapat', 'Sosialisasi', 'Pelatihan', 'Bimbingan Teknis',
            'Monitoring', 'Evaluasi', 'Pelantikan', 'Lainnya'
        ];
        return view('kegiatan.create', compact('jenisKegiatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'          => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'jenis_kegiatan' => 'required|string|max:100',
            'lokasi'         => 'required|string|max:255',
            'keterangan'     => 'nullable|string',
            'fotos'          => 'required|array|min:1',
            'fotos.*'        => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $kegiatan = Kegiatan::create([
            'judul'          => $request->judul,
            'tanggal'        => $request->tanggal,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'lokasi'         => $request->lokasi,
            'keterangan'     => $request->keterangan,
            'user_id'        => auth()->id(),
        ]);

        foreach ($request->file('fotos') as $index => $foto) {
            $path = $foto->store('kegiatan', 'public');
            KegiatanFoto::create([
                'kegiatan_id' => $kegiatan->id,
                'file'        => $path,
                'urutan'      => $index,
            ]);
        }

        return redirect()->route('kegiatan.show', $kegiatan)
                         ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load('fotos', 'user');
        return view('kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        $kegiatan->load('fotos');
        $jenisKegiatan = [
            'Rapat', 'Sosialisasi', 'Pelatihan', 'Bimbingan Teknis',
            'Monitoring', 'Evaluasi', 'Pelantikan', 'Lainnya'
        ];
        return view('kegiatan.edit', compact('kegiatan', 'jenisKegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'judul'          => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'jenis_kegiatan' => 'required|string|max:100',
            'lokasi'         => 'required|string|max:255',
            'keterangan'     => 'nullable|string',
            'fotos'          => 'nullable|array',
            'fotos.*'        => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $kegiatan->update([
            'judul'          => $request->judul,
            'tanggal'        => $request->tanggal,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'lokasi'         => $request->lokasi,
            'keterangan'     => $request->keterangan,
        ]);

        // Upload foto baru kalau ada
        if ($request->hasFile('fotos')) {
            $lastUrutan = $kegiatan->fotos()->max('urutan') ?? 0;
            foreach ($request->file('fotos') as $index => $foto) {
                $path = $foto->store('kegiatan', 'public');
                KegiatanFoto::create([
                    'kegiatan_id' => $kegiatan->id,
                    'file'        => $path,
                    'urutan'      => $lastUrutan + $index + 1,
                ]);
            }
        }

        return redirect()->route('kegiatan.show', $kegiatan)
                         ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        // Hapus semua foto
        foreach ($kegiatan->fotos as $foto) {
            if (Storage::disk('public')->exists($foto->file)) {
                Storage::disk('public')->delete($foto->file);
            }
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')
                         ->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function destroyFoto(KegiatanFoto $foto)
    {
        if (Storage::disk('public')->exists($foto->file)) {
            Storage::disk('public')->delete($foto->file);
        }
        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
