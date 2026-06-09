<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('kegiatan.show', $kegiatan) }}" class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Edit Kegiatan</h2>
                <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi kegiatan</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-blue-500 to-blue-700"></div>

            <form action="{{ route('kegiatan.update', $kegiatan) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
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

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $kegiatan->judul) }}"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $kegiatan->tanggal->format('Y-m-d')) }}"
                               class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Kegiatan <span class="text-red-500">*</span></label>
                        <select name="jenis_kegiatan" class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition bg-white">
                            @foreach($jenisKegiatan as $jenis)
                                <option value="{{ $jenis }}" {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi) }}"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                </div>

                {{-- Foto existing --}}
                @if($kegiatan->fotos->count() > 0)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Saat Ini</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($kegiatan->fotos as $foto)
                                <div class="relative group aspect-square rounded-lg overflow-hidden border border-gray-200">
                                    <img src="{{ asset('storage/' . $foto->file) }}" class="w-full h-full object-cover">
                                    <form action="{{ route('kegiatan.foto.destroy', $foto) }}" method="POST"
                                          onsubmit="return confirm('Hapus foto ini?')"
                                          class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded-lg text-xs font-medium">Hapus</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Tambah foto baru --}}
                <div x-data="{ previews: [] }">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Tambah Foto Baru <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <label for="fotos_baru"
                           class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-200 bg-gray-50 hover:border-red-400 hover:bg-red-50 rounded-xl cursor-pointer transition group">
                        <input type="file" id="fotos_baru" name="fotos[]" accept="image/*" multiple class="hidden"
                               @change="
                                    previews = [];
                                    for(let f of $event.target.files) {
                                        let r = new FileReader();
                                        r.onload = e => previews.push(e.target.result);
                                        r.readAsDataURL(f);
                                    }
                               ">
                        <svg class="w-7 h-7 text-gray-300 group-hover:text-red-400 transition mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <p class="text-xs text-gray-500 group-hover:text-red-500 transition">Klik untuk tambah foto</p>
                    </label>
                    <div x-show="previews.length > 0" class="mt-2 grid grid-cols-4 gap-2">
                        <template x-for="(src, i) in previews" :key="i">
                            <div class="aspect-square rounded-lg overflow-hidden border border-gray-200">
                                <img :src="src" class="w-full h-full object-cover">
                            </div>
                        </template>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition resize-none">{{ old('keterangan', $kegiatan->keterangan) }}</textarea>
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                        Update Kegiatan
                    </button>
                    <a href="{{ route('kegiatan.show', $kegiatan) }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>