<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📄 Detail Dokumentasi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    {{-- Header --}}
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $dokumentasi->judul }}</h1>
                            <div class="flex gap-2 mt-2">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $dokumentasi->jenis_pemilu }}
                                </span>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $dokumentasi->tahun }}
                                </span>
                                @if($dokumentasi->jenis_surat_suara)
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $dokumentasi->jenis_surat_suara === 'tunanetra' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $dokumentasi->jenis_surat_suara === 'tunanetra' ? '👁️ Tunanetra' : '👁️ Normal' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('dokumentasi.edit', $dokumentasi->id) }}" 
                               class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                Edit
                            </a>
                            <a href="{{ route('dokumentasi.index') }}" 
                               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                                Kembali
                            </a>
                        </div>
                    </div>

                    {{-- File Preview --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">File Dokumen</h3>
                        @if($dokumentasi->file)
                            <div class="border rounded-lg p-4 bg-gray-50">
                                @php
                                    $extension = strtolower(pathinfo($dokumentasi->file, PATHINFO_EXTENSION));
                                    $fileUrl = asset('storage/' . $dokumentasi->file);
                                @endphp
                                
                                {{-- Image Preview --}}
                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ $fileUrl }}" 
                                         alt="{{ $dokumentasi->judul }}"
                                         class="max-w-full h-auto rounded-lg shadow-md">
                                {{-- PDF Preview with iframe --}}
                                @elseif($extension === 'pdf')
                                    <div class="relative w-full h-96 bg-gray-100 rounded-lg overflow-hidden">
                                        <iframe src="{{ $fileUrl }}" 
                                                class="w-full h-full"
                                                style="border: none;">
                                            <p style="text-align: center; padding: 20px; color: #666;">
                                                Preview PDF tidak tersedia. <a href="{{ $fileUrl }}" target="_blank" class="text-red-600 underline">Buka file</a>
                                            </p>
                                        </iframe>
                                    </div>
                                {{-- Other Files --}}
                                @else
                                    <div class="flex items-center gap-4">
                                        <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                            <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                                        </svg>
                                        <div>
                                            <p class="font-medium">{{ basename($dokumentasi->file) }}</p>
                                            <a href="{{ $fileUrl }}" 
                                               target="_blank"
                                               class="text-red-600 hover:text-red-800 text-sm">
                                                Buka File →
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                 {{-- Download Button --}}
                                <div class="mt-4">
                                    <a href="{{ route('dokumentasi.download', $dokumentasi->id) }}" 
                                    class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Download File
                                    </a>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada file</p>
                        @endif
                    </div>

                    {{-- Keterangan --}}
                    @if($dokumentasi->keterangan)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">Keterangan</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $dokumentasi->keterangan }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Metadata --}}
                    <div class="border-t pt-4 text-sm text-gray-500">
                        <p>Dibuat: {{ $dokumentasi->created_at->format('d F Y, H:i') }}</p>
                        <p>Diperbarui: {{ $dokumentasi->updated_at->format('d F Y, H:i') }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>