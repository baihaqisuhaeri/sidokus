<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📊 Dashboard Dokumentasi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Welcome Section --}}
            <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-2xl shadow-xl p-8 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                        <p class="text-red-100">Kelola dan pantau dokumentasi surat suara dengan mudah</p>
                    </div>
                    <div class="hidden md:block">
                        <a href="{{ route('dokumentasi.create') }}" class="bg-white text-red-600 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition shadow-lg">+ Tambah Dokumen</a>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Dokumen</p>
                            <h3 class="text-4xl font-bold text-gray-800">{{ $totalDocuments ?? 0 }}</h3>
                            <p class="text-sm text-red-600 mt-2">📈 Semua jenis pemilu</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-4">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Bulan Ini</p>
                            <h3 class="text-4xl font-bold text-gray-800">{{ $documentsThisMonth ?? 0 }}</h3>
                            <p class="text-sm text-red-600 mt-2">📅 Ditambahkan bulan ini</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-4">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Jenis Pemilu</p>
                            <h3 class="text-4xl font-bold text-gray-800">{{ $totalTypes ?? 0 }}</h3>
                            <p class="text-sm text-red-600 mt-2">🗳️ Kategori tersedia</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-4">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tahun Terakhir</p>
                            <h3 class="text-4xl font-bold text-gray-800">{{ $latestYear ?? 2024 }}</h3>
                            <p class="text-sm text-red-600 mt-2">📅 Data terbaru</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-4">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Normal Documents --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Normal</p>
                            <h3 class="text-4xl font-bold text-gray-800">{{ $normalDocuments ?? 0 }}</h3>
                            <p class="text-sm text-blue-600 mt-2">👁️ Untuk umum</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-4">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
            </div>

    {{-- Tunanetra Documents --}}
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Tunanetra</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $tunanetraDocuments ?? 0 }}</h3>
                <p class="text-sm text-purple-600 mt-2">👁️ Braille</p>
            </div>
            <div class="bg-purple-100 rounded-full p-4">
                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

            {{-- Document Type Cards --}}
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">📋 Jenis Surat Suara</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    {{-- President Card --}}
                    <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=President" class="group bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-lg p-6 text-white hover:shadow-2xl transition transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-4xl font-bold">{{ $documentsByType['President'] ?? 0 }}</span>
                        </div>
                        <h4 class="text-xl font-bold mb-1">Presiden</h4>
                        <p class="text-red-100 text-sm">Surat suara pemilihan presiden</p>
                        <div class="mt-4 flex items-center text-sm text-red-100"><span>Lihat semua →</span></div>
                    </a>

                    {{-- DPR Card --}}
                    <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=DPR" class="group bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-lg p-6 text-white hover:shadow-2xl transition transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span class="text-4xl font-bold">{{ $documentsByType['DPR'] ?? 0 }}</span>
                        </div>
                        <h4 class="text-xl font-bold mb-1">DPR</h4>
                        <p class="text-red-100 text-sm">Surat suara pemilihan DPR</p>
                        <div class="mt-4 flex items-center text-sm text-red-100"><span>Lihat semua →</span></div>
                    </a>

                    {{-- DPD Card --}}
                    <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=DPD" class="group bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-lg p-6 text-white hover:shadow-2xl transition transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="text-4xl font-bold">{{ $documentsByType['DPD'] ?? 0 }}</span>
                        </div>
                        <h4 class="text-xl font-bold mb-1">DPD</h4>
                        <p class="text-red-100 text-sm">Surat suara pemilihan DPD</p>
                        <div class="mt-4 flex items-center text-sm text-red-100"><span>Lihat semua →</span></div>
                    </a>

                    {{-- Provinsi Card --}}
                    <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=Provinsi" class="group bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-lg p-6 text-white hover:shadow-2xl transition transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-4xl font-bold">{{ $documentsByType['Provinsi'] ?? 0 }}</span>
                        </div>
                        <h4 class="text-xl font-bold mb-1">Provinsi</h4>
                        <p class="text-red-100 text-sm">Surat suara pemilihan provinsi</p>
                        <div class="mt-4 flex items-center text-sm text-red-100"><span>Lihat semua →</span></div>
                    </a>

                                        {{-- Kabupaten/Kota Card --}}
                    <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=Kabupaten/Kota" class="group bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-lg p-6 text-white hover:shadow-2xl transition transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <span class="text-4xl font-bold">{{ $documentsByType['Kabupaten/Kota'] ?? 0 }}</span>
                        </div>
                        <h4 class="text-xl font-bold mb-1">Kabupaten/Kota</h4>
                        <p class="text-red-100 text-sm">Surat suara pemilihan kabupaten/kota</p>
                        <div class="mt-4 flex items-center text-sm text-red-100"><span>Lihat semua →</span></div>
                    </a>

                    {{-- All Documents Card --}}
                    <a href="{{ route('dokumentasi.index') }}" class="group bg-gradient-to-br from-gray-700 to-gray-900 rounded-2xl shadow-lg p-6 text-white hover:shadow-2xl transition transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                            </div>
                            <span class="text-4xl font-bold">{{ $totalDocuments ?? 0 }}</span>
                        </div>
                        <h4 class="text-xl font-bold mb-1">Semua Dokumen</h4>
                        <p class="text-gray-300 text-sm">Lihat semua dokumentasi</p>
                        <div class="mt-4 flex items-center text-sm text-gray-300"><span>Lihat semua →</span></div>
                    </a>

                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🚀 Aksi Cepat</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('dokumentasi.create') }}" class="flex items-center gap-3 p-4 bg-red-50 rounded-lg hover:bg-red-100 transition">
                        <div class="bg-red-600 text-white p-2 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Tambah Dokumen</p>
                            <p class="text-sm text-gray-500">Upload dokumentasi baru</p>
                        </div>
                    </a>
                    <a href="{{ route('dokumentasi.index') }}" class="flex items-center gap-3 p-4 bg-red-50 rounded-lg hover:bg-red-100 transition">
                        <div class="bg-red-600 text-white p-2 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Lihat Semua</p>
                            <p class="text-sm text-gray-500">Daftar dokumentasi lengkap</p>
                        </div>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-4 bg-red-50 rounded-lg hover:bg-red-100 transition">
                        <div class="bg-red-600 text-white p-2 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Profil</p>
                            <p class="text-sm text-gray-500">Edit profil akun</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Tips Section --}}
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">💡 Tips Penggunaan</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Gunakan format PDF untuk dokumen resmi</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Upload maksimal 5MB per file</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Gunakan filter untuk mencari dokumen dengan cepat</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>