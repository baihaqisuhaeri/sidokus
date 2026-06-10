<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\KategoriBerkas;
use App\Models\SubKategoriBerkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    public function index(Request $request)
    {
        $query = Berkas::with('subKategori.kategori', 'user');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_surat', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori_id')) {
            $query->whereHas('subKategori', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori_id);
            });
        }

        if ($request->filled('sub_kategori_id')) {
            $query->where('sub_kategori_id', $request->sub_kategori_id);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $berkas = $query->latest()->paginate(15);
        $kategoris = KategoriBerkas::with('subKategoris')->orderBy('urutan')->get();

        return view('berkas.index', compact('berkas', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriBerkas::with('subKategoris')->orderBy('urutan')->get();
        return view('berkas.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'sub_kategori_id' => 'required|exists:sub_kategori_berkas,id',
            'nomor_surat'     => 'nullable|string|max:255',
            'tahun'           => 'required|numeric|min:2000|max:2100',
            'file'            => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:50240',
            'keterangan'      => 'nullable|string',
        ]);

        $path = $request->file('file')->store('berkas', 'public');

        Berkas::create([
            'judul'           => $request->judul,
            'sub_kategori_id' => $request->sub_kategori_id,
            'nomor_surat'     => $request->nomor_surat,
            'tahun'           => $request->tahun,
            'file'            => $path,
            'keterangan'      => $request->keterangan,
            'user_id'         => auth()->id(),
        ]);

        return redirect()->route('berkas.index')
                         ->with('success', 'Berkas berhasil ditambahkan.');
    }

    public function show(Berkas $berka)
    {
        $berka->load('subKategori.kategori', 'user');
        return view('berkas.show', ['berkas' => $berka]);
    }

    public function edit(Berkas $berka)
    {
        $kategoris = KategoriBerkas::with('subKategoris')->orderBy('urutan')->get();
        return view('berkas.edit', ['berkas' => $berka, 'kategoris' => $kategoris]);
    }

    public function update(Request $request, Berkas $berka)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'sub_kategori_id' => 'required|exists:sub_kategori_berkas,id',
            'nomor_surat'     => 'nullable|string|max:255',
            'tahun'           => 'required|numeric|min:2000|max:2100',
            'file'            => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:50240',
            'keterangan'      => 'nullable|string',
        ]);

        $data = [
            'judul'           => $request->judul,
            'sub_kategori_id' => $request->sub_kategori_id,
            'nomor_surat'     => $request->nomor_surat,
            'tahun'           => $request->tahun,
            'keterangan'      => $request->keterangan,
        ];

        if ($request->hasFile('file')) {
            if ($berka->file && Storage::disk('public')->exists($berka->file)) {
                Storage::disk('public')->delete($berka->file);
            }
            $data['file'] = $request->file('file')->store('berkas', 'public');
        }

        $berka->update($data);

        return redirect()->route('berkas.index')
                         ->with('success', 'Berkas berhasil diperbarui.');
    }

    public function destroy(Berkas $berka)
    {
        if ($berka->file && Storage::disk('public')->exists($berka->file)) {
            Storage::disk('public')->delete($berka->file);
        }
        $berka->delete();

        return redirect()->route('berkas.index')
                         ->with('success', 'Berkas berhasil dihapus.');
    }

    public function download(Berkas $berka)
    {
        if (!Storage::disk('public')->exists($berka->file)) {
            abort(404, 'File tidak ditemukan');
        }
        return Storage::disk('public')->download(
            $berka->file,
            $berka->judul . '.' . $berka->extension
        );
    }

    // API untuk get sub kategori by kategori (untuk dropdown dinamis)
    public function getSubKategori(KategoriBerkas $kategori)
    {
        return response()->json($kategori->subKategoris);
    }
}