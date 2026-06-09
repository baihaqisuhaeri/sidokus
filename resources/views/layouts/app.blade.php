<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SiDokus') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&family=dm-serif-display:400&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'DM Sans', sans-serif; background: #f4f5f7; }
        .nav-link-active { background: rgba(255,255,255,0.15); color: #fff; }
        .nav-link { color: rgba(255,255,255,0.75); transition: all .2s; }
        .nav-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <header class="bg-red-700 shadow-lg sticky top-0 z-50" x-data="{ open: false, userMenu: false }">
        <div class="mx-auto px-4 sm:px-6 lg:px-8" style="max-width:1280px">
            <div class="flex items-center justify-between h-14">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                    <div class="bg-white rounded-lg p-1 shadow-md">
                        <img src="{{ asset('images/logo_kpu.png') }}" alt="KPU" class="h-7 w-7 object-contain">
                    </div>
                    <div class="leading-none">
                        <span class="text-white font-bold text-base tracking-tight">Si<span class="text-yellow-300">Dokus</span></span>
                        <p class="text-red-200 text-[10px] leading-tight">Sistem Dokumentasi KPU</p>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link px-3.5 py-2 rounded-lg text-sm font-medium flex items-center gap-2 {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('dokumentasi.index') }}"
                       class="nav-link px-3.5 py-2 rounded-lg text-sm font-medium flex items-center gap-2 {{ request()->routeIs('dokumentasi.*') ? 'nav-link-active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Surat Suara
                    </a>

                    <a href="{{ route('kegiatan.index') }}"
                    class="nav-link px-3.5 py-2 rounded-lg text-sm font-medium flex items-center gap-2 {{ request()->routeIs('kegiatan.*') ? 'nav-link-active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Kegiatan
                    </a>

                    <a href="{{ route('berkas.index') }}"
                    class="nav-link px-3.5 py-2 rounded-lg text-sm font-medium flex items-center gap-2 {{ request()->routeIs('berkas.*') ? 'nav-link-active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Berkas
                    </a>

                    @if(auth()->user()->isAdmin())
                        <div class="w-px h-5 bg-white/20 mx-1"></div>
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link px-3.5 py-2 rounded-lg text-sm font-medium flex items-center gap-2 {{ request()->routeIs('admin.users.*') ? 'nav-link-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Kelola User
                        </a>
                        <a href="{{ route('admin.satkers.index') }}"
                           class="nav-link px-3.5 py-2 rounded-lg text-sm font-medium flex items-center gap-2 {{ request()->routeIs('admin.satkers.*') ? 'nav-link-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Kelola Satker
                        </a>
                    @endif
                </nav>

                {{-- User Menu --}}
                <div class="hidden md:block relative" x-data="{ userMenu: false }">
                    <button @click="userMenu = !userMenu"
                            class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white pl-2 pr-3 py-1.5 rounded-xl transition text-sm font-medium">
                        <div class="w-7 h-7 bg-yellow-400 rounded-lg flex items-center justify-center text-red-800 font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                        <svg class="w-3.5 h-3.5 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="userMenu" @click.outside="userMenu = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50"
                         style="display:none;">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            @if(Auth::user()->satker)
                                <p class="text-xs text-red-500 mt-0.5 truncate">{{ Auth::user()->satker->nama }}</p>
                            @endif
                        </div>
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </a>
                        <div class="border-t border-gray-100 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="flex items-center gap-2.5 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Mobile Hamburger --}}
                <button @click="open = !open" class="md:hidden text-white p-2 rounded-lg hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden border-t border-red-600/50">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-sm">Dashboard</a>
                <a href="{{ route('dokumentasi.index') }}" class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-sm">Surat Suara</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-sm">Kelola User</a>
                    <a href="{{ route('admin.satkers.index') }}" class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-sm">Kelola Satker</a>
                @endif
            </div>
            <div class="border-t border-red-600/50 px-4 py-3">
                <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-red-200">{{ Auth::user()->email }}</p>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="nav-link block px-3 py-2 rounded-lg text-sm">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link w-full text-left px-3 py-2 rounded-lg text-sm">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- Page Header --}}
    @isset($header)
        <div class="bg-white border-b border-gray-200">
            <div class="mx-auto px-4 sm:px-6 lg:px-8 py-4" style="max-width:1280px">
                {{ $header }}
            </div>
        </div>
    @endisset

    {{-- Flash Messages --}}
    @if(session('success') || session('error'))
        <div class="mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full" style="max-width:1280px"
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600">✕</button>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600">✕</button>
                </div>
            @endif
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1 mx-auto w-full px-4 sm:px-6 lg:px-8 py-6" style="max-width:1280px">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-3">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between" style="max-width:1280px">
            <p class="text-xs text-gray-400">© {{ date('Y') }} SiDokus — Sistem Dokumentasi KPU</p>
            <p class="text-xs text-gray-400">v1.0.0</p>
        </div>
    </footer>

</body>
</html>