<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Aparat Kelurahan Notoharjo')</title>
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
<body class="bg-slate-100 text-slate-800 flex min-h-screen relative overflow-x-hidden" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-950/70 z-40 md:hidden backdrop-blur-sm"
         style="display: none;"></div>

    <!-- Sidebar Navigation (Desktop Fixed, Mobile Slide-over Drawer) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
           class="fixed md:sticky top-0 left-0 z-50 w-72 md:w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 h-screen border-r border-slate-800 transition-transform duration-300 ease-in-out shadow-2xl md:shadow-none">
        
        <!-- Logo Brand & Mobile Close Button -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('logo-lampung-tengah.png') }}" alt="Logo Kabupaten Lampung Tengah" class="w-10 h-10 object-contain shrink-0">
                <div>
                    <span class="text-sm font-extrabold text-white block tracking-tight leading-tight">KELURAHAN NOTOHARJO</span>
                    <span class="text-[10px] text-emerald-400 font-semibold block uppercase tracking-wider">Panel Aparat Desa</span>
                </div>
            </div>
            <!-- Mobile Close Sidebar Button -->
            <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white p-2 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Menu Links -->
        <div class="flex-grow p-4 space-y-1.5 text-xs font-semibold overflow-y-auto">
            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 py-2">Utama</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-gauge-high text-sm w-5"></i>
                <span>Dashboard Ringkasan</span>
            </a>

            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 py-2 pt-4">Pelayanan Surat</div>

            <a href="{{ route('admin.surat.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.surat.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-envelope-open-text text-sm w-5"></i>
                <span>Verifikasi & Cetak Surat</span>
            </a>

            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 py-2 pt-4">Kependudukan</div>

            <a href="{{ route('admin.kependudukan.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.kependudukan.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-users text-sm w-5"></i>
                <span>Data Warga & KK</span>
            </a>

            <a href="{{ route('admin.mutasi.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.mutasi.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-arrows-turn-to-dots text-sm w-5"></i>
                <span>Mutasi (Lahir/Mati/Pindah)</span>
            </a>

            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 py-2 pt-4">Masyarakat & Publikasi</div>

            <a href="{{ route('admin.pengaduan.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.pengaduan.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-bullhorn text-sm w-5"></i>
                <span>Aspirasi & Pengaduan</span>
            </a>

            <a href="{{ route('admin.potensi.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.potensi.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-store text-sm w-5"></i>
                <span>Pasar Welit & UMKM</span>
            </a>

            <a href="{{ route('admin.transparansi.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.transparansi.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie text-sm w-5"></i>
                <span>Transparansi Anggaran</span>
            </a>

            <a href="{{ route('admin.berita.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.berita.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-newspaper text-sm w-5"></i>
                <span>Berita & Informasi</span>
            </a>

            <a href="{{ route('admin.agenda.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.agenda.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-calendar-days text-sm w-5"></i>
                <span>Agenda Kelurahan</span>
            </a>

            <a href="{{ route('admin.galeri.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.galeri.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-images text-sm w-5"></i>
                <span>Galeri Foto & Video</span>
            </a>

            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 py-2 pt-4">Penelitian / Skripsi</div>

            <a href="{{ route('admin.laporan.pengujian') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.laporan.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-clipboard-check text-sm w-5"></i>
                <span>Matriks UAT & Pengujian</span>
            </a>

            <a href="{{ route('diagram.sistem') }}" target="_blank" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition hover:bg-slate-800 text-slate-400 hover:text-white">
                <i class="fa-solid fa-diagram-project text-sm w-5 text-emerald-400"></i>
                <span>Diagram Sistem (ERD & UML)</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[9px] ml-auto"></i>
            </a>
        </div>

        <!-- User Info Bottom -->
        <div class="p-4 border-t border-slate-800 text-xs">
            <div class="p-3 bg-slate-800/80 rounded-xl space-y-1">
                <span class="font-bold text-white block truncate">{{ Auth::user()->name }}</span>
                <span class="text-[11px] text-emerald-400 font-medium block truncate">{{ Auth::user()->jabatan ?? 'Aparat Desa' }}</span>
                <span class="text-[10px] px-2 py-0.5 bg-slate-700 text-slate-300 rounded uppercase font-mono inline-block">
                    {{ Auth::user()->role }}
                </span>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Header (Responsive Mobile + Desktop) -->
        <header class="h-16 sm:h-20 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm sm:shadow-none">
            <div class="flex items-center space-x-3">
                <!-- Hamburger Button for Mobile -->
                <button type="button" @click="sidebarOpen = true" class="md:hidden w-10 h-10 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl flex items-center justify-center transition">
                    <i class="fa-solid fa-bars text-base"></i>
                </button>
                
                <!-- Mobile Brand on Header -->
                <div class="flex items-center space-x-2 md:hidden">
                    <img src="{{ asset('logo-lampung-tengah.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                    <span class="text-xs font-black text-slate-900 tracking-tight">NOTOHARJO</span>
                </div>

                <span class="hidden sm:inline-flex text-xs font-bold px-3 py-1 bg-slate-100 text-slate-700 rounded-lg">
                    <i class="fa-solid fa-calendar-days text-emerald-600 mr-1.5"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-4">
                @include('partials.notifikasi_bell')

                <a href="{{ route('home') }}" target="_blank" class="px-3 sm:px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center space-x-1.5" title="Buka Website Publik">
                    <i class="fa-solid fa-globe text-xs"></i>
                    <span class="hidden sm:inline">Lihat Web Publik</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 sm:px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Flash Notice -->
        <div class="px-4 sm:px-8 pt-4 sm:pt-6">
            @if(session('success'))
                <div class="p-3.5 sm:p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center space-x-3 shadow-sm text-xs sm:text-sm">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-base shrink-0"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error') || $errors->any())
                <div class="p-3.5 sm:p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-start space-x-3 shadow-sm text-xs sm:text-sm">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-base mt-0.5 shrink-0"></i>
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

        <!-- Body Content -->
        <main class="p-4 sm:p-8 flex-grow">
            @yield('content')
        </main>
    </div>

</body>
</html>

