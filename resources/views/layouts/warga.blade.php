<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Mandiri Warga - Kelurahan Notoharjo')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-lampung-tengah.png') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen pb-16 md:pb-0">

    <!-- Topbar Warga -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14 sm:h-16 items-center">
                <div class="flex items-center space-x-2.5 sm:space-x-3">
                    <a href="{{ route('home') }}" class="shrink-0">
                        <img src="{{ asset('logo-lampung-tengah.png') }}" alt="Logo Kabupaten Lampung Tengah" class="w-8 h-8 sm:w-10 sm:h-10 object-contain">
                    </a>
                    <div>
                        <span class="text-sm sm:text-base font-bold text-slate-900 block leading-tight">Portal Warga Mandiri</span>
                        <span class="text-[10px] sm:text-xs text-emerald-600 font-semibold block">Kelurahan Notoharjo</span>
                    </div>
                </div>

                <div class="flex items-center space-x-2 sm:space-x-4">
                    <div class="text-right hidden sm:block">
                        <span class="text-xs font-bold text-slate-800 block">{{ Auth::user()->name }}</span>
                        <span class="text-[11px] text-slate-500 block">NIK: {{ Auth::user()->nik ?? '-' }}</span>
                    </div>

                    @include('partials.notifikasi_bell')

                    <a href="{{ route('home') }}" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-xs font-semibold text-slate-700 rounded-lg transition flex items-center space-x-1" title="Lihat Website Publik">
                        <i class="fa-solid fa-house text-xs"></i>
                        <span class="hidden md:inline">Web Publik</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-2.5 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg text-xs font-bold transition flex items-center space-x-1" title="Keluar">
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Subnav Tabs Warga (Swipeable on Mobile) -->
    <div class="bg-white border-b border-slate-200 shadow-sm overflow-x-auto scrollbar-none">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-6 sm:space-x-8 text-xs sm:text-sm font-semibold whitespace-nowrap min-w-max">
                <a href="{{ route('warga.dashboard') }}" class="py-3.5 sm:py-4 border-b-2 {{ request()->routeIs('warga.dashboard') ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition flex items-center space-2">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Dashboard Saya</span>
                </a>
                <a href="{{ route('warga.surat.create') }}" class="py-3.5 sm:py-4 border-b-2 {{ request()->routeIs('warga.surat.create') ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition flex items-center space-2">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <span>Ajukan Surat Baru</span>
                </a>
                <a href="{{ route('warga.surat.index') }}" class="py-3.5 sm:py-4 border-b-2 {{ request()->routeIs('warga.surat.index') || request()->routeIs('warga.surat.detail') ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition flex items-center space-2">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Riwayat & Tracking Surat</span>
                </a>
                <a href="{{ route('warga.pengaduan.index') }}" class="py-3.5 sm:py-4 border-b-2 {{ request()->routeIs('warga.pengaduan.*') ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition flex items-center space-2">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Aspirasi & Pengaduan</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Flash Notification -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center space-x-3 mb-4 shadow-sm text-xs sm:text-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error') || $errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-start space-x-3 mb-4 shadow-sm text-xs sm:text-sm">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-base mt-0.5"></i>
                <div>
                    @if(session('error')) <div>{{ session('error') }}</div> @endif
                    @if($errors->any())
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Content -->
    <main class="flex-grow max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-6 sm:py-8 w-full">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-4 sm:py-6 text-center text-[11px] sm:text-xs text-slate-500">
        Portal Mandiri Warga Kelurahan Notoharjo, Kec. Trimurjo, Kab. Lampung Tengah.
    </footer>

    <!-- Mobile Bottom App Bar for Warga Portal -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 shadow-xl px-2 py-1 flex justify-around items-center">
        <a href="{{ route('warga.dashboard') }}" class="flex flex-col items-center py-1 px-3 rounded-xl transition {{ request()->routeIs('warga.dashboard') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-gauge-high text-base"></i>
            <span class="text-[10px] mt-0.5">Dashboard</span>
        </a>
        <a href="{{ route('warga.surat.create') }}" class="flex flex-col items-center py-1 px-3 rounded-xl transition {{ request()->routeIs('warga.surat.create') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-file-circle-plus text-base"></i>
            <span class="text-[10px] mt-0.5">Ajukan</span>
        </a>
        <a href="{{ route('warga.surat.index') }}" class="flex flex-col items-center py-1 px-3 rounded-xl transition {{ request()->routeIs('warga.surat.index') || request()->routeIs('warga.surat.detail') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-clock-rotate-left text-base"></i>
            <span class="text-[10px] mt-0.5">Riwayat</span>
        </a>
        <a href="{{ route('warga.pengaduan.index') }}" class="flex flex-col items-center py-1 px-3 rounded-xl transition {{ request()->routeIs('warga.pengaduan.*') ? 'text-emerald-600 font-bold' : 'text-slate-500' }}">
            <i class="fa-solid fa-bullhorn text-base"></i>
            <span class="text-[10px] mt-0.5">Aspirasi</span>
        </a>
        <a href="{{ route('home') }}" class="flex flex-col items-center py-1 px-3 rounded-xl transition text-slate-500 hover:text-emerald-600">
            <i class="fa-solid fa-globe text-base"></i>
            <span class="text-[10px] mt-0.5">Web</span>
        </a>
    </nav>
</body>
</html>

