<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Dashboard</h2>
                <p class="text-sm text-gray-500 mt-0.5">Selamat datang, <span class="font-semibold text-red-600">{{ Auth::user()->name }}</span></p>
            </div>
            <a href="{{ route('dokumentasi.create') }}"
               class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Dokumen
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Welcome Banner --}}
        <div class="relative bg-gradient-to-r from-red-700 via-red-600 to-red-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 20px 20px;"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full translate-x-1/3 -translate-y-1/3"></div>
            <div class="relative z-10 p-7 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <p class="text-red-200 text-sm mb-1">👋 Selamat Datang Kembali</p>
                    <h1 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h1>
                    @if(Auth::user()->satker)
                        <p class="text-red-200 text-sm mt-1">{{ Auth::user()->satker->nama }}</p>
                    @endif
                    <p class="text-red-100 text-sm mt-1">Kelola dan pantau dokumentasi surat suara dengan mudah</p>
                </div>
            </div>
        </div>

        {{-- Stats Row 1 --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Dokumen</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ $totalDocuments ?? 0 }}</h3>
                        <p class="text-sm text-red-600 mt-2">📈 Semua jenis pemilu</p>
                    </div>
                    <div class="bg-red-100 rounded-2xl p-3.5">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Bulan Ini</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ $documentsThisMonth ?? 0 }}</h3>
                        <p class="text-sm text-red-600 mt-2">📅 Ditambahkan bulan ini</p>
                    </div>
                    <div class="bg-red-100 rounded-2xl p-3.5">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Jenis Pemilu</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ $totalTypes ?? 0 }}</h3>
                        <p class="text-sm text-red-600 mt-2">🗳️ Kategori tersedia</p>
                    </div>
                    <div class="bg-red-100 rounded-2xl p-3.5">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tahun Terakhir</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ $latestYear ?? 2024 }}</h3>
                        <p class="text-sm text-red-600 mt-2">📅 Data terbaru</p>
                    </div>
                    <div class="bg-red-100 rounded-2xl p-3.5">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Row 2: Normal + Tunanetra --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Normal</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ $normalDocuments ?? 0 }}</h3>
                        <p class="text-sm text-blue-600 mt-2">👁️ Untuk umum</p>
                    </div>
                    <div class="bg-blue-100 rounded-2xl p-3.5">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tunanetra</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ $tunanetraDocuments ?? 0 }}</h3>
                        <p class="text-sm text-purple-600 mt-2">👁️ Braille</p>
                    </div>
                    <div class="bg-purple-100 rounded-2xl p-3.5">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jenis Surat Suara --}}
        <div>
            <h3 class="text-base font-bold text-gray-800 mb-4">📋 Jenis Surat Suara</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=President"
                   class="group relative bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-md p-6 text-white hover:shadow-xl transition hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-28 h-28 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-2.5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-4xl font-bold">{{ $documentsByType['President'] ?? 0 }}</span>
                    </div>
                    <h4 class="text-lg font-bold mb-0.5">Presiden</h4>
                    <p class="text-red-100 text-sm">Surat suara pemilihan presiden</p>
                    <div class="mt-3 text-sm text-red-100 group-hover:translate-x-1 transition-transform">Lihat semua →</div>
                </a>

                <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=DPR"
                   class="group relative bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-md p-6 text-white hover:shadow-xl transition hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-28 h-28 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-2.5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <span class="text-4xl font-bold">{{ $documentsByType['DPR'] ?? 0 }}</span>
                    </div>
                    <h4 class="text-lg font-bold mb-0.5">DPR</h4>
                    <p class="text-red-100 text-sm">Surat suara pemilihan DPR</p>
                    <div class="mt-3 text-sm text-red-100 group-hover:translate-x-1 transition-transform">Lihat semua →</div>
                </a>

                <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=DPD"
                   class="group relative bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-md p-6 text-white hover:shadow-xl transition hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-28 h-28 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-2.5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-4xl font-bold">{{ $documentsByType['DPD'] ?? 0 }}</span>
                    </div>
                    <h4 class="text-lg font-bold mb-0.5">DPD</h4>
                    <p class="text-red-100 text-sm">Surat suara pemilihan DPD</p>
                    <div class="mt-3 text-sm text-red-100 group-hover:translate-x-1 transition-transform">Lihat semua →</div>
                </a>

                <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=Provinsi"
                   class="group relative bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-md p-6 text-white hover:shadow-xl transition hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-28 h-28 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-2.5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-4xl font-bold">{{ $documentsByType['Provinsi'] ?? 0 }}</span>
                    </div>
                    <h4 class="text-lg font-bold mb-0.5">Provinsi</h4>
                    <p class="text-red-100 text-sm">Surat suara pemilihan provinsi</p>
                    <div class="mt-3 text-sm text-red-100 group-hover:translate-x-1 transition-transform">Lihat semua →</div>
                </a>

                <a href="{{ route('dokumentasi.index') }}?jenis_pemilu=Kabupaten/Kota"
                   class="group relative bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-md p-6 text-white hover:shadow-xl transition hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-28 h-28 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-2.5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span class="text-4xl font-bold">{{ $documentsByType['Kabupaten/Kota'] ?? 0 }}</span>
                    </div>
                    <h4 class="text-lg font-bold mb-0.5">Kabupaten/Kota</h4>
                    <p class="text-red-100 text-sm">Surat suara pemilihan kabupaten/kota</p>
                    <div class="mt-3 text-sm text-red-100 group-hover:translate-x-1 transition-transform">Lihat semua →</div>
                </a>

                <a href="{{ route('dokumentasi.index') }}"
                   class="group relative bg-gradient-to-br from-gray-700 to-gray-900 rounded-2xl shadow-md p-6 text-white hover:shadow-xl transition hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-28 h-28 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-2.5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <span class="text-4xl font-bold">{{ $totalDocuments ?? 0 }}</span>
                    </div>
                    <h4 class="text-lg font-bold mb-0.5">Semua Dokumen</h4>
                    <p class="text-gray-300 text-sm">Lihat semua dokumentasi</p>
                    <div class="mt-3 text-sm text-gray-300 group-hover:translate-x-1 transition-transform">Lihat semua →</div>
                </a>

            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-sm font-bold text-gray-800 mb-4">🚀 Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <a href="{{ route('dokumentasi.create') }}"
                   class="group flex items-center gap-3 p-3.5 bg-red-50 hover:bg-red-100 rounded-xl transition border border-transparent hover:border-red-200">
                    <div class="bg-red-600 group-hover:bg-red-700 text-white p-2 rounded-lg transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Tambah Dokumen</p>
                        <p class="text-xs text-gray-500">Upload dokumentasi baru</p>
                    </div>
                </a>
                <a href="{{ route('dokumentasi.index') }}"
                   class="group flex items-center gap-3 p-3.5 bg-red-50 hover:bg-red-100 rounded-xl transition border border-transparent hover:border-red-200">
                    <div class="bg-red-600 group-hover:bg-red-700 text-white p-2 rounded-lg transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Lihat Semua</p>
                        <p class="text-xs text-gray-500">Daftar dokumentasi lengkap</p>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="group flex items-center gap-3 p-3.5 bg-red-50 hover:bg-red-100 rounded-xl transition border border-transparent hover:border-red-200">
                    <div class="bg-red-600 group-hover:bg-red-700 text-white p-2 rounded-lg transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Profil</p>
                        <p class="text-xs text-gray-500">Edit profil akun</p>
                    </div>
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}"
                       class="group flex items-center gap-3 p-3.5 bg-red-50 hover:bg-red-100 rounded-xl transition border border-transparent hover:border-red-200">
                        <div class="bg-red-600 group-hover:bg-red-700 text-white p-2 rounded-lg transition shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Kelola User</p>
                            <p class="text-xs text-gray-500">Manajemen pengguna</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.satkers.index') }}"
                       class="group flex items-center gap-3 p-3.5 bg-red-50 hover:bg-red-100 rounded-xl transition border border-transparent hover:border-red-200">
                        <div class="bg-red-600 group-hover:bg-red-700 text-white p-2 rounded-lg transition shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Kelola Satker</p>
                            <p class="text-xs text-gray-500">Manajemen satuan kerja</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>

        {{-- Tips --}}
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-sm font-bold text-gray-800 mb-3">💡 Tips Penggunaan</h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Gunakan format PDF untuk dokumen resmi
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Upload maksimal 5MB per file
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Gunakan filter untuk mencari dokumen dengan cepat
                </li>
            </ul>
        </div>

    </div>

</x-app-layout>