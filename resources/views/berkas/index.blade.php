<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Berkas</h2>
                <p class="text-sm text-gray-500 mt-0.5">Kelola penyimpanan berkas dan dokumen</p>
            </div>
            <a href="{{ route('berkas.create') }}"
               class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Berkas
            </a>
        </div>
    </x-slot>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6"
         x-data="{
            kategoriId: '{{ request('kategori_id') }}',
            subKategoris: [],
            kategoris: {{ $kategoris->map(fn($k) => ['id' => $k->id, 'subs' => $k->subKategoris->map(fn($s) => ['id' => $s->id, 'nama' => $s->nama])])->values()->toJson() }},
            init() {
                if (this.kategoriId) this.loadSubs(this.kategoriId);
            },
            loadSubs(id) {
                const found = this.kategoris.find(k => k.id == id);
                this.subKategoris = found ? found.subs : [];
            }
         }">
        <form action="{{ route('berkas.index') }}" method="GET" class="flex flex-wrap items-center gap-3">

            <select name="kategori_id"
                    x-model="kategoriId"
                    @change="loadSubs($event.target.value)"
                    class="border border-gray-200 rounded-lg pl-3 pr-8 py-2 text-sm outline-none focus:ring-2 focus:ring-red-500 bg-white text-gray-700">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            </select>

            <select name="sub_kategori_id"
                    class="border border-gray-200 rounded-lg pl-3 pr-8 py-2 text-sm outline-none focus:ring-2 focus:ring-red-500 bg-white text-gray-700">
                <option value="">Semua Jenis</option>
                <template x-for="sub in subKategoris" :key="sub.id">
                    <option :value="sub.id" :selected="sub.id == {{ request('sub_kategori_id', 'null') }}" x-text="sub.nama"></option>
                </template>
                {{-- fallback untuk saat page reload --}}
                @if(request('sub_kategori_id'))
                    @php $selectedSub = \App\Models\SubKategoriBerkas::find(request('sub_kategori_id')); @endphp
                    @if($selectedSub)
                        <option value="{{ $selectedSub->id }}" selected>{{ $selectedSub->nama }}</option>
                    @endif
                @endif
            </select>

            <input type="number" name="tahun" placeholder="Tahun"
                   value="{{ request('tahun') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-red-500 w-24 text-gray-700">

            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" placeholder="Cari judul atau nomor surat..."
                       value="{{ request('search') }}"
                       class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500 text-gray-700">
            </div>

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Cari</button>

            @if(request()->hasAny(['search', 'kategori_id', 'sub_kategori_id', 'tahun']))
                <a href="{{ route('berkas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm transition">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    @if($berkas->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Berkas</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Surat</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tahun</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($berkas as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0
                                        {{ $item->is_pdf ? 'bg-red-100' : ($item->is_image ? 'bg-blue-100' : 'bg-gray-100') }}">
                                        @if($item->is_pdf)
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                            </svg>
                                        @elseif($item->is_image)
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $item->judul }}</p>
                                        @if($item->keterangan)
                                            <p class="text-xs text-gray-400 truncate max-w-xs">{{ $item->keterangan }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-xs font-semibold text-gray-600">{{ $item->kategori_nama }}</p>
                                <span class="text-xs text-gray-400">{{ $item->subKategori?->nama ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-4 text-gray-500 text-sm">{{ $item->nomor_surat ?? '—' }}</td>
                            <td class="px-5 py-4 text-gray-600 font-medium">{{ $item->tahun }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('berkas.preview', $item) }}" target="_blank"
                                       class="px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-600 rounded-lg text-xs font-medium transition">Preview</a>
                                    <a href="{{ route('berkas.download', $item) }}"
                                       class="px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg text-xs font-medium transition">Download</a>
                                    <a href="{{ route('berkas.edit', $item) }}"
                                       class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-medium transition">Edit</a>
                                    <form action="{{ route('berkas.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus berkas ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium transition">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($berkas->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">{{ $berkas->links() }}</div>
            @endif
        </div>
    @else
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Belum ada berkas</h3>
            <p class="text-sm text-gray-400 mb-6">Mulai tambahkan berkas pertama</p>
            <a href="{{ route('berkas.create') }}"
               class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                + Tambah Berkas
            </a>
        </div>
    @endif

</x-app-layout>