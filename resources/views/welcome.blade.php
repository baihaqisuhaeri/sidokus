<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dokumentasi Surat Suara') }}</title>

    <!-- Favicon -->
   

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    {{-- Logo KPU Style --}}
                    <div class="text-white p-2 rounded-lg">
                        <img src="{{ asset('images/logo_kpu.png') }}" alt="Logo" class="h-12 w-auto">
                    </div>
                    <div>
                        <span class="text-xl font-bold text-gray-900">Si<span class="text-red-600">Dokus</span></span>
                        <p class="text-xs text-gray-500">Sistem Informasi Dokumentasi</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-red-600 font-medium">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600 font-medium">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="bg-gradient-to-br from-red-600 to-red-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Text Content --}}
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                        Sistem Informasi<br>
                        <span class="text-yellow-300">Dokumentasi</span><br>
                        Surat Suara
                    </h1>
                    <p class="text-lg text-red-100 mb-8 leading-relaxed">
                        Platform digital untuk menyimpan, mengelola, dan mengakses dokumentasi surat suara pemilihan umum secara terorganisir dan aman.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('login') }}" class="bg-white text-red-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition text-center shadow-lg">
                            Mulai Sekarang
                        </a>
                        
                    </div>
                </div>

                {{-- Image --}}
                <div class="relative">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 shadow-2xl">
                        <img src="{{ asset('images/logo_kpu.png') }}" alt="Dashboard Preview" class="rounded-xl shadow-lg w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    

   

</body>
</html>