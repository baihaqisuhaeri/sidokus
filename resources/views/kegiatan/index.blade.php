<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Dokumentasi Kegiatan</h2>
                <p class="text-sm text-gray-500 mt-0.5">Kelola dokumentasi foto kegiatan KPU</p>
            </div>
            <a href="{{ route('kegiatan.create') }}"
               class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kegiatan
            </a>
        </div>
    </x-slot>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <form action="{{ route('kegiatan.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <select name="jenis_kegiatan" class="border border-gray-200 rounded-lg pl-3 pr-8 py-2 text-sm outline-none focus:ring-2 focus:ring-red-500 bg-white text-gray-700">
                <option value="">Semua Jenis</option>
                @foreach($jenisKegiatan as $jenis)
                    <option value="{{ $jenis }}" {{ request('jenis_kegiatan') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                @endforeach
            </select>

            <input type="number" name="tahun" placeholder="Tahun"
                   value="{{ request('tahun') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-red-500 w-24 text-gray-700">

            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" placeholder="Cari judul atau lokasi..."
                       value="{{ request('search') }}"
                       class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500 text-gray-700">
            </div>

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Cari</button>

            @if(request()->hasAny(['search', 'jenis_kegiatan', 'tahun']))
                <a href="{{ route('kegiatan.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm transition">Reset</a>
            @endif
        </form>
    </div>

    {{-- Grid --}}
    @if($kegiatans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($kegiatans as $kegiatan)
                @php $fotoUtama = $kegiatan->fotos->first(); @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition overflow-hidden group">

                    {{-- Foto Preview --}}
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        @if($fotoUtama)
                            <img src="{{ asset('storage/' . $fotoUtama->file) }}"
                                 alt="{{ $kegiatan->judul }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Badge jumlah foto --}}
                        @if($kegiatan->fotos_count > 1)
                            <div class="absolute bottom-2.5 right-2.5 bg-black/60 text-white text-xs font-semibold px-2 py-1 rounded-lg flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $kegiatan->fotos_count }} foto
                            </div>
                        @endif

                        {{-- Jenis badge --}}
                        <div class="absolute top-2.5 left-2.5">
                            <span class="bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded-lg">
                                {{ $kegiatan->jenis_kegiatan }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 text-sm mb-1 line-clamp-2">{{ $kegiatan->judul }}</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-400 mb-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $kegiatan->tanggal->format('d M Y') }}
                        </div>
                        <div class="flex items-center gap-1 text-xs text-gray-400 mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $kegiatan->lokasi }}
                        </div>

                        <div class="flex items-center gap-2 border-t border-gray-50 pt-3">
                            <a href="{{ route('kegiatan.show', $kegiatan) }}"
                               class="flex-1 flex items-center justify-center gap-1 py-1.5 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-medium transition">
                                Detail
                            </a>
                            <a href="{{ route('kegiatan.edit', $kegiatan) }}"
                               class="flex-1 flex items-center justify-center gap-1 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-medium transition">
                                Edit
                            </a>
                            <form action="{{ route('kegiatan.destroy', $kegiatan) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus kegiatan ini beserta semua fotonya?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="flex items-center justify-center p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $kegiatans->links() }}</div>

    @else
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Belum ada kegiatan</h3>
            <p class="text-sm text-gray-400 mb-6">Mulai tambahkan dokumentasi kegiatan pertama</p>
            <a href="{{ route('kegiatan.create') }}"
               class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                + Tambah Kegiatan
            </a>
        </div>
    @endif

</x-app-layout>