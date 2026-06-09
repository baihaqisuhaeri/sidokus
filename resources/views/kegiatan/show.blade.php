<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('kegiatan.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Detail Kegiatan</h2>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $kegiatan->judul }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('kegiatan.edit', $kegiatan) }}"
                   class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold transition">
                    Edit
                </a>
                <form action="{{ route('kegiatan.destroy', $kegiatan) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus kegiatan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-semibold transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-5">

        {{-- Info Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-lg">{{ $kegiatan->jenis_kegiatan }}</span>
                <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg">{{ $kegiatan->tanggal->format('d M Y') }}</span>
                <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg">📍 {{ $kegiatan->lokasi }}</span>
            </div>
            <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $kegiatan->judul }}</h1>
            @if($kegiatan->keterangan)
                <p class="text-sm text-gray-600 leading-relaxed">{{ $kegiatan->keterangan }}</p>
            @endif
            <div class="border-t border-gray-100 mt-4 pt-3 text-xs text-gray-400">
                Ditambahkan: {{ $kegiatan->created_at->format('d M Y, H:i') }}
                @if($kegiatan->user) · oleh {{ $kegiatan->user->name }} @endif
            </div>
        </div>

        {{-- Foto Gallery --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-800">Foto Kegiatan ({{ $kegiatan->fotos->count() }})</h3>
                <a href="{{ route('kegiatan.edit', $kegiatan) }}"
                   class="text-xs text-red-600 hover:text-red-700 font-medium">+ Tambah Foto</a>
            </div>

            @if($kegiatan->fotos->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3" x-data="{ lightbox: null }">
                    @foreach($kegiatan->fotos as $foto)
                        <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-100">
                            <img src="{{ asset('storage/' . $foto->file) }}"
                                 alt="Foto {{ $loop->iteration }}"
                                 class="w-full h-full object-cover cursor-pointer group-hover:scale-105 transition-transform duration-300"
                                 @click="lightbox = '{{ asset('storage/' . $foto->file) }}'">

                            {{-- Hapus foto --}}
                            <form action="{{ route('kegiatan.foto.destroy', $foto) }}" method="POST"
                                  onsubmit="return confirm('Hapus foto ini?')"
                                  class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-7 h-7 bg-red-600 text-white rounded-lg flex items-center justify-center shadow hover:bg-red-700 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach

                    {{-- Lightbox --}}
                    <div x-show="lightbox" @click="lightbox = null" @keydown.escape.window="lightbox = null"
                         class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4 cursor-zoom-out"
                         style="display:none;">
                        <img :src="lightbox" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-8">Belum ada foto</p>
            @endif
        </div>

    </div>
</x-app-layout>