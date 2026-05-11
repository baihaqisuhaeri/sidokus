<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary;

class DokumentasiController extends Controller
{
    private function uploadToCloudinary($file)
    {
        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
        $extension = $file->getClientOriginalExtension();
        $resourceType = in_array($extension, ['pdf']) ? 'raw' : 'image';
        
        $result = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => 'dokumentasi',
                'resource_type' => $resourceType
            ]
        );
        return $result['secure_url'];
    }

    public function index(Request $request)
    {
        $query = Dokumentasi::query();
        if ($request->has('search') && $request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->has('jenis_pemilu') && $request->jenis_pemilu) {
            $query->where('jenis_pemilu', $request->jenis_pemilu);
        }
        if ($request->filled('jenis_surat_suara')) {
            $query->where('jenis_surat_suara', $request->jenis_surat_suara);
        }
        if ($request->has('tahun') && $request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        $data = $query->latest()->paginate(10);
        return view('dokumentasi.index', compact('data'));
    }

    public function create()
    {
        return view('dokumentasi.create');
    }

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

        $filePath = $this->uploadToCloudinary($request->file('file'));

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

    public function show(Dokumentasi $dokumentasi)
    {
        return view('dokumentasi.show', compact('dokumentasi'));
    }

    public function edit(Dokumentasi $dokumentasi)
    {
        return view('dokumentasi.edit', compact('dokumentasi'));
    }

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

        if ($request->hasFile('file')) {
            $data['file'] = $this->uploadToCloudinary($request->file('file'));
        }

        $dokumentasi->update($data);

        return redirect()->route('dokumentasi.index')
                        ->with('success', 'Dokumentasi berhasil diperbarui');
    }

    public function destroy(Dokumentasi $dokumentasi)
    {
        $dokumentasi->delete();
        return redirect()->route('dokumentasi.index')
                        ->with('success', 'Dokumentasi berhasil dihapus');
    }

    public function download(Dokumentasi $dokumentasi)
    {
        $fileUrl = $dokumentasi->file;
        
        if (!$fileUrl) {
            abort(404, 'File tidak ditemukan');
        }

        return redirect($fileUrl);
    }

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