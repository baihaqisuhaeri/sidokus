<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('kegiatan.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Tambah Kegiatan</h2>
                <p class="text-sm text-gray-500 mt-0.5">Dokumentasikan kegiatan dengan foto</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-red-500 to-red-700"></div>

            <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
                        <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                        <ul class="space-y-0.5">
                            @foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                           placeholder="Contoh: Rapat Koordinasi Persiapan Pemilu 2024"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                </div>

                {{-- Tanggal + Jenis --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                               class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Kegiatan <span class="text-red-500">*</span></label>
                        <select name="jenis_kegiatan" class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition bg-white">
                            <option value="">-- Pilih --</option>
                            @foreach($jenisKegiatan as $jenis)
                                <option value="{{ $jenis }}" {{ old('jenis_kegiatan') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Lokasi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                           placeholder="Contoh: Aula KPU Pusat, Jakarta"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                </div>

                {{-- Upload Foto --}}
                <div x-data="{ previews: [] }">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Foto Kegiatan <span class="text-red-500">*</span>
                        <span class="text-gray-400 font-normal">(bisa pilih banyak sekaligus)</span>
                    </label>

                    <label for="fotos"
                           class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 bg-gray-50 hover:border-red-400 hover:bg-red-50 rounded-xl cursor-pointer transition group">
                        <input type="file" id="fotos" name="fotos[]" accept="image/*" multiple class="hidden"
                               @change="
                                    previews = [];
                                    for(let f of $event.target.files) {
                                        let r = new FileReader();
                                        r.onload = e => previews.push(e.target.result);
                                        r.readAsDataURL(f);
                                    }
                               ">
                        <svg class="w-8 h-8 text-gray-300 group-hover:text-red-400 transition mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-500 group-hover:text-red-500 transition">Klik untuk pilih foto</p>
                        <p class="text-xs text-gray-400">JPG, PNG — Maks. 5MB per foto</p>
                    </label>

                    {{-- Preview --}}
                    <div x-show="previews.length > 0" class="mt-3 grid grid-cols-4 gap-2">
                        <template x-for="(src, i) in previews" :key="i">
                            <div class="relative aspect-square rounded-lg overflow-hidden border border-gray-200">
                                <img :src="src" class="w-full h-full object-cover">
                            </div>
                        </template>
                    </div>

                    @error('fotos')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    @error('fotos.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="keterangan" rows="3"
                              placeholder="Deskripsi singkat kegiatan..."
                              class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition resize-none">{{ old('keterangan') }}</textarea>
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                        Simpan Kegiatan
                    </button>
                    <a href="{{ route('kegiatan.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>