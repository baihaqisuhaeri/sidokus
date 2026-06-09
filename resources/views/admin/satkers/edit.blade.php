<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.satkers.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800">Edit Satker</h2>
                <p class="text-sm text-gray-500 mt-0.5">Perbarui data {{ $satker->nama }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-blue-500 to-blue-700"></div>

            <form action="{{ route('admin.satkers.update', $satker) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

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
                    <input type="text" name="nama" value="{{ old('nama', $satker->nama) }}"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Tingkatan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tingkatan <span class="text-red-500">*</span></label>
                    <select name="tingkatan" class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition bg-white">
                        <option value="pusat" {{ old('tingkatan', $satker->tingkatan) == 'pusat' ? 'selected' : '' }}>KPU Pusat</option>
                        <option value="provinsi" {{ old('tingkatan', $satker->tingkatan) == 'provinsi' ? 'selected' : '' }}>KPU Provinsi</option>
                        <option value="kabupaten_kota" {{ old('tingkatan', $satker->tingkatan) == 'kabupaten_kota' ? 'selected' : '' }}>KPU Kabupaten/Kota</option>
                    </select>
                    @error('tingkatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Wilayah --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Wilayah <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="wilayah" value="{{ old('wilayah', $satker->wilayah) }}"
                           placeholder="Contoh: DKI Jakarta, Kab. Bogor"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                    @error('wilayah')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Status Aktif --}}
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $satker->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <label for="is_active" class="text-sm font-semibold text-gray-700">Satker Aktif</label>
                    <p class="text-xs text-gray-400 ml-auto">Nonaktifkan jika satker tidak lagi digunakan</p>
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                        Update Satker
                    </button>
                    <a href="{{ route('admin.satkers.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>