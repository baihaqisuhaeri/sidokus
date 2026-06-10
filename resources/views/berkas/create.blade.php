<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('berkas.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Tambah Berkas</h2>
                <p class="text-sm text-gray-500 mt-0.5">Upload berkas atau dokumen baru</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto"
         x-data="{
            kategoris: {{ $kategoris->map(fn($k) => [
                'id' => $k->id,
                'nama' => $k->nama,
                'subs' => $k->subKategoris->map(fn($s) => [
                    'id' => $s->id,
                    'nama' => $s->nama,
                    'has_nomor_surat' => $s->has_nomor_surat,
                ])->values()
            ])->values()->toJson() }},
            selectedKategori: null,
            selectedSub: null,
            subKategoris: [],
            showNomorSurat: false,
            selectKategori(id) {
                this.selectedKategori = id;
                this.selectedSub = null;
                this.showNomorSurat = false;
                const found = this.kategoris.find(k => k.id == id);
                this.subKategoris = found ? found.subs : [];
            },
            selectSub(id) {
                this.selectedSub = id;
                const sub = this.subKategoris.find(s => s.id == id);
                this.showNomorSurat = sub ? sub.has_nomor_surat : false;
            }
         }">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-red-500 to-red-700"></div>

            <form action="{{ route('berkas.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
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
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Berkas <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                           placeholder="Contoh: ND Karo Deptek Sekjen - Kegiatan Bimtek Mei 2024"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select @change="selectKategori($event.target.value)"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Kategori --}}
                <div x-show="subKategoris.length > 0">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Berkas <span class="text-red-500">*</span></label>
                    <select name="sub_kategori_id"
                            @change="selectSub($event.target.value)"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition bg-white">
                        <option value="">-- Pilih Jenis --</option>
                        <template x-for="sub in subKategoris" :key="sub.id">
                            <option :value="sub.id" x-text="sub.nama"></option>
                        </template>
                    </select>
                    @error('sub_kategori_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Nomor Surat (kondisional) --}}
                <div x-show="showNomorSurat" x-transition>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nomor Surat <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                           placeholder="Contoh: 012/KPU/ND/V/2024"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                    @error('nomor_surat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Tahun --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}"
                           min="2000" max="2100"
                           class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition">
                    @error('tahun')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Upload File --}}
                <div x-data="{ fileName: '' }">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Upload File <span class="text-red-500">*</span></label>
                    <label for="file"
                           class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-200 bg-gray-50 hover:border-red-400 hover:bg-red-50 rounded-xl cursor-pointer transition group">
                        <input type="file" id="file" name="file" class="hidden"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                               @change="fileName = $event.target.files[0]?.name || ''">
                        <svg class="w-8 h-8 text-gray-300 group-hover:text-red-400 transition mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm text-gray-500 group-hover:text-red-500 transition" x-text="fileName || 'Klik untuk upload file'"></p>
                        <p class="text-xs text-gray-400">PDF, DOC, DOCX, XLS, XLSX, JPG, PNG — Maks. 50MB</p>
                    </label>
                    @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="keterangan" rows="3"
                              placeholder="Deskripsi singkat berkas..."
                              class="w-full px-4 py-2.5 border-2 border-gray-200 focus:border-red-500 rounded-xl text-sm outline-none transition resize-none">{{ old('keterangan') }}</textarea>
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                        Simpan Berkas
                    </button>
                    <a href="{{ route('berkas.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>