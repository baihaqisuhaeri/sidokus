<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📝 Tambah Dokumentasi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Card Container --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                
                {{-- Header --}}
                <div class="bg-gradient-to-r from-red-600 to-red-800 px-6 py-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 rounded-xl p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Tambah Dokumentasi</h1>
                            <p class="text-red-100 text-sm">Isi form di bawah untuk menambahkan dokumentasi baru</p>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('dokumentasi.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="p-6 space-y-6">

                    @csrf

                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-red-800">Terjadi kesalahan:</p>
                                    <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Input Group: Judul --}}
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                Judul Dokumen
                            </span>
                        </label>
                        <input type="text" 
                               id="judul"
                               name="judul" 
                               value="{{ old('judul') }}"
                               placeholder="Contoh: Surat Suara Pemilu 2024 - Jakarta Pusat"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-400">
                        @error('judul')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Group: Jenis Pemilu --}}
                    <div>
                        <label for="jenis_pemilu" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Jenis Pemilihan
                            </span>
                        </label>
                        <select id="jenis_pemilu" 
                                name="jenis_pemilu" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white">
                            <option value="">-- Pilih Jenis Pemilihan --</option>
                            <option value="President" {{ old('jenis_pemilu') == 'President' ? 'selected' : '' }}>🗳️ Presiden</option>
                            <option value="DPR" {{ old('jenis_pemilu') == 'DPR' ? 'selected' : '' }}>🏛️ DPR</option>
                            <option value="DPD" {{ old('jenis_pemilu') == 'DPD' ? 'selected' : '' }}>👥 DPD</option>
                            <option value="Provinsi" {{ old('jenis_pemilu') == 'Provinsi' ? 'selected' : '' }}>🗺️ Provinsi</option>
                            <option value="Kabupaten/Kota" {{ old('jenis_pemilu') == 'Kabupaten/Kota' ? 'selected' : '' }}>📍 Kabupaten/Kota</option>
                        </select>
                        @error('jenis_pemilu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Group: Tahun --}}
                    <div>
                        <label for="tahun" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tahun Pemilihan
                            </span>
                        </label>
                        <input type="number" 
                               id="tahun"
                               name="tahun" 
                               value="{{ old('tahun', date('Y')) }}"
                               min="2000"
                               max="2100"
                               placeholder="Contoh: 2024"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-400">
                        @error('tahun')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Group: Jenis Surat Suara --}}
<div>
    <label for="jenis_surat_suara" class="block text-sm font-semibold text-gray-700 mb-2">
        <span class="flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Jenis Surat Suara
        </span>
    </label>
    <select id="jenis_surat_suara" 
            name="jenis_surat_suara" 
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white">
        <option value="normal">👁️ Normal (Untuk Umum)</option>
        <option value="tunanetra">👁️ Tunanetra (Braille)</option>
    </select>
    @error('jenis_surat_suara')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                    {{-- Input Group: Upload File --}}
                    <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Upload File
                            </span>
                        </label>
                        
                        {{-- File Upload Area --}}
                        <div class="border-2 border-dashed border-red-300 rounded-xl p-6 hover:border-red-500 transition bg-red-50">
                            <input type="file" 
                                   id="file"
                                   name="file" 
                                   accept="image/*,application/pdf"
                                   class="hidden"
                                   onchange="previewFile()">
                            <label for="file" class="cursor-pointer">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-red-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-gray-600 font-medium">Klik untuk upload file</p>
                                    <p class="text-gray-400 text-sm mt-1">atau drag & drop file di sini</p>
                                    <p class="text-gray-400 text-xs mt-2">Format: PDF, JPG, PNG (Max 5MB)</p>
                                </div>
                            </label>
                        </div>
                        @error('file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Group: Keterangan --}}
                    <div>
                        <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Keterangan (Opsional)
                            </span>
                        </label>
                        <textarea id="keterangan" 
                                  name="keterangan" 
                                  rows="4"
                                  placeholder="Tambahkan keterangan tambahan tentang dokumen ini..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-400 resize-none">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-4 pt-4 border-t">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-red-600 to-red-800 text-white px-6 py-3 rounded-xl font-semibold hover:from-red-700 hover:to-red-900 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Dokumentasi
                            </span>
                        </button>
                        <a href="{{ route('dokumentasi.index') }}" 
                           class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition text-center">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>