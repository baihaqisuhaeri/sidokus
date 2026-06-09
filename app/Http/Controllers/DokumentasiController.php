<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dokumentasi::query();

        // Search berdasarkan judul
        if ($request->has('search') && $request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan jenis pemilihan
        if ($request->has('jenis_pemilu') && $request->jenis_pemilu) {
            $query->where('jenis_pemilu', $request->jenis_pemilu);
        }

        // Filter Jenis Surat Suara
        if ($request->filled('jenis_surat_suara')) {
            $query->where('jenis_surat_suara', $request->jenis_surat_suara);
        }

        // Filter berdasarkan tahun
        if ($request->has('tahun') && $request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        // Urutkan dan paginate
        $data = $query->latest()->paginate(10);

        return view('dokumentasi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokumentasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_pemilu' => 'required|string',
            'jenis_surat_suara' => 'required|in:normal,tunanetra',
            'tahun' => 'required|numeric|min:2000|max:2100',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string'
        ]);

        // Simpan file
        $filePath = $request->file('file')->store('dokumentasi', 'public');

        Dokumentasi::create([
            'judul' => $request->judul,
            'jenis_pemilu' => $request->jenis_pemilu,
            'jenis_surat_suara' => $request->jenis_surat_suara,
            'tahun' => $request->tahun,
            'file' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumentasi.index')
                        ->with('success', 'Dokumentasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokumentasi $dokumentasi)
    {
        return view('dokumentasi.show', compact('dokumentasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumentasi $dokumentasi)
    {
        return view('dokumentasi.edit', compact('dokumentasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_pemilu' => 'required|string',
            'jenis_surat_suara' => 'required|in:normal,tunanetra',
            'tahun' => 'required|numeric|min:2000|max:2100',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string'
        ]);

        $data = [
            'judul' => $request->judul,
            'jenis_pemilu' => $request->jenis_pemilu,
            'jenis_surat_suara' => $request->jenis_surat_suara,
            'tahun' => $request->tahun,
            'keterangan' => $request->keterangan,
        ];

        // Kalau ada file baru, hapus yang lama terus simpan yang baru
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($dokumentasi->file && Storage::disk('public')->exists($dokumentasi->file)) {
                Storage::disk('public')->delete($dokumentasi->file);
            }
            
            // Simpan file baru
            $data['file'] = $request->file('file')->store('dokumentasi', 'public');
        }

        $dokumentasi->update($data);

        return redirect()->route('dokumentasi.index')
                        ->with('success', 'Dokumentasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumentasi $dokumentasi)
    {
        // Hapus file dari storage
        if ($dokumentasi->file && Storage::disk('public')->exists($dokumentasi->file)) {
            Storage::disk('public')->delete($dokumentasi->file);
        }

        // Hapus data dari database
        $dokumentasi->delete();

        return redirect()->route('dokumentasi.index')
                        ->with('success', 'Dokumentasi berhasil dihapus');
    }

    public function download(Dokumentasi $dokumentasi)
    {
        $filePath = $dokumentasi->file;
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        $file = Storage::disk('public')->get($filePath);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        
        return response($file, 200, [
            'Content-Type' => $this->getMimeType($extension),
            'Content-Disposition' => 'attachment; filename="' . $dokumentasi->judul . '.' . $extension . '"',
        ]);
    }

    /**
     * Get MIME type berdasarkan extension
     */
    private function getMimeType($extension)
    {
        $mimes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];

        return $mimes[$extension] ?? 'application/octet-stream';
    }
}