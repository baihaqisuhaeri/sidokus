<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.satkers.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800">Tambah Satker</h2>
                <p class="text-sm text-gray-500 mt-0.5">Tambah satuan kerja baru</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-red-500 to-red-700"></div>

            <form action="{{ route('admin.satkers.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
                        <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                        <ul class="space-y-0.5">
                            @foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Satker <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           placeholder="Contoh: KPU Provinsi DKI Jakarta"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Tingkatan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tingkatan <span class="text-red-500">*</span></label>
                    <select name="tingkatan" class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition bg-white">
                        <option value="">-- Pilih Tingkatan --</option>
                        <option value="pusat" {{ old('tingkatan') == 'pusat' ? 'selected' : '' }}>KPU Pusat</option>
                        <option value="provinsi" {{ old('tingkatan') == 'provinsi' ? 'selected' : '' }}>KPU Provinsi</option>
                        <option value="kabupaten_kota" {{ old('tingkatan') == 'kabupaten_kota' ? 'selected' : '' }}>KPU Kabupaten/Kota</option>
                    </select>
                    @error('tingkatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Wilayah --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Wilayah <span class="text-gray-400 font-normal">(opsional, untuk provinsi/kab/kota)</span>
                    </label>
                    <input type="text" name="wilayah" value="{{ old('wilayah') }}"
                           placeholder="Contoh: DKI Jakarta, Kab. Bogor"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                    @error('wilayah')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                        Simpan Satker
                    </button>
                    <a href="{{ route('admin.satkers.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>