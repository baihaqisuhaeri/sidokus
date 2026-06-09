<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satker;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    public function index()
    {
        $satkers = Satker::withCount('users')->orderBy('tingkatan')->orderBy('nama')->paginate(15);
        return view('admin.satkers.index', compact('satkers'));
    }

    public function create()
    {
        return view('admin.satkers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => ['required', 'string', 'max:255'],
            'tingkatan' => ['required', 'in:pusat,provinsi,kabupaten_kota'],
            'wilayah'   => ['nullable', 'string', 'max:255'],
        ]);

        Satker::create($request->only('nama', 'tingkatan', 'wilayah'));

        return redirect()->route('admin.satkers.index')
                         ->with('success', 'Satker berhasil ditambahkan.');
    }

    public function edit(Satker $satker)
    {
        return view('admin.satkers.edit', compact('satker'));
    }

    public function update(Request $request, Satker $satker)
    {
        $request->validate([
            'nama'      => ['required', 'string', 'max:255'],
            'tingkatan' => ['required', 'in:pusat,provinsi,kabupaten_kota'],
            'wilayah'   => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $satker->update([
            'nama'      => $request->nama,
            'tingkatan' => $request->tingkatan,
            'wilayah'   => $request->wilayah,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.satkers.index')
                         ->with('success', 'Satker berhasil diperbarui.');
    }

    public function destroy(Satker $satker)
    {
        if ($satker->users()->count() > 0) {
            return redirect()->route('admin.satkers.index')
                             ->with('error', 'Satker tidak bisa dihapus karena masih memiliki user.');
        }

        $satker->delete();

        return redirect()->route('admin.satkers.index')
                         ->with('success', 'Satker berhasil dihapus.');
    }
}