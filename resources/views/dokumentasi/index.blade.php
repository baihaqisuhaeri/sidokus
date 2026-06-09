<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📁 Daftar Dokumentasi Surat Suara</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Flash Message --}}
            @if (session('success'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header + Tambah Button --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <a href="{{ route('dokumentasi.create') }}" class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Dokumentasi
                </a>

                {{-- Search Form --}}
                <form action="{{ route('dokumentasi.index') }}" method="GET" class="flex flex-wrap gap-2">
                    <select name="jenis_pemilu" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none text-sm">
                        <option value="">Semua Jenis</option>
                        <option value="President" {{ request('jenis_pemilu') == 'President' ? 'selected' : '' }}>President</option>
                        <option value="DPR" {{ request('jenis_pemilu') == 'DPR' ? 'selected' : '' }}>DPR</option>
                        <option value="DPD" {{ request('jenis_pemilu') == 'DPD' ? 'selected' : '' }}>DPD</option>
                        <option value="Provinsi" {{ request('jenis_pemilu') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                        <option value="Kabupaten/Kota" {{ request('jenis_pemilu') == 'Kabupaten/Kota' ? 'selected' : '' }}>Kabupaten/Kota</option>
                    </select>
                    <input type="number" name="tahun" placeholder="Tahun" value="{{ request('tahun') }}" class="border border-gray-300 rounded-lg px-3 py-2 w-24 focus:ring-2 focus:ring-red-500 focus:outline-none text-sm">
                    <input type="text" name="search" placeholder="Cari judul..." value="{{ request('search') }}" class="border border-gray-300 rounded-lg px-3 py-2 w-48 focus:ring-2 focus:ring-red-500 focus:outline-none text-sm">
                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition text-sm">Cari</button>
                    @if(request('search') || request('jenis_pemilu') || request('tahun'))
                        <a href="{{ route('dokumentasi.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition text-sm">Reset</a>
                    @endif
                </form>
            </div>

            {{-- Document Cards --}}
            @if($data->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($data as $index => $item)
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 overflow-hidden">
                            {{-- File Preview --}}
                            <div class="relative h-48 bg-gray-100 overflow-hidden">
                                @if($item->file)
                                    @php
                                        $extension = strtolower(pathinfo($item->file, PATHINFO_EXTENSION));
                                        $fileUrl = asset('storage/' . $item->file);
                                    @endphp
                                    
                                    {{-- Image Preview --}}
                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ $fileUrl }}" 
                                             alt="{{ $item->judul }}"
                                             class="w-full h-full object-cover">
                                    {{-- PDF Preview with iframe --}}
                                    @elseif($extension === 'pdf')
                                        <iframe src="{{ $fileUrl }}" 
                                                class="w-full h-full"
                                                style="background: #f5f5f5;">
                                            <p style="text-align: center; padding: 20px; color: #666;">
                                                Preview PDF tidak tersedia. <a href="{{ $fileUrl }}" target="_blank" class="text-red-600 underline">Buka file</a>
                                            </p>
                                        </iframe>
                                    {{-- Other Files --}}
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-600 to-gray-800">
                                            <div class="text-center">
                                                <svg class="w-20 h-20 text-white mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span class="text-white text-sm font-medium">{{ strtoupper($extension) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Type Badge --}}
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-white/90 text-gray-800 shadow-sm">
                                        {{ $item->jenis_pemilu }}
                                    </span>
                                </div>
                                
                                {{-- Year Badge --}}
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-600 text-white shadow-sm">
                                        {{ $item->tahun }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $item->judul }}</h3>
                                @if($item->keterangan)
                                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $item->keterangan }}</p>
                                @endif

                                {{-- Actions --}}
<div class="flex items-center justify-between">
    <div class="flex gap-2">
        {{-- Download Button --}}
        <a href="{{ route('dokumentasi.download', $item->id) }}" 
           target="_blank"
           class="flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download
        </a>
        
        {{-- Lihat Button --}}
        <a href="{{ asset('storage/' . $item->file) }}" 
           target="_blank"
           class="flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Lihat
        </a>
        
        {{-- Detail Button --}}
        <a href="{{ route('dokumentasi.show', $item->id) }}" 
           class="flex items-center gap-1 px-3 py-1.5 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Detail
        </a>
    </div>
</div>

                                {{-- Action Buttons --}}
                                <div class="flex gap-2 mt-4 pt-4 border-t">
                                    <a href="{{ route('dokumentasi.edit', $item->id) }}" 
                                       class="flex-1 flex items-center justify-center gap-1 px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('dokumentasi.destroy', $item->id) }}" 
                                          method="POST" 
                                          class="flex-1"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center justify-center gap-1 px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm w-full">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $data->links() }}
                </div>

            @else
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum ada data dokumentasi</h3>
                    <p class="text-gray-500 mb-6">Mulai tambahkan dokumentasi surat suara pertama Anda</p>
                    <a href="{{ route('dokumentasi.create') }}" class="inline-flex items-center bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Dokumentasi Pertama
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>