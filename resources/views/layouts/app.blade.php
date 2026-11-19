<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kelurahan Notoharjo - Kecamatan Trimurjo, Lampung Tengah')</title>
    <meta name="description" content="Portal Resmi Website dan Pelayanan Administrasi Sistem Informasi Kelurahan Notoharjo, Kecamatan Trimurjo, Kabupaten Lampung Tengah.">
    <link rel="icon" type="image/png" href="{{ asset('logo-lampung-tengah.png') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        secondary: {
                            600: '#0284c7',
                            700: '#0369a1',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Page Enter: body fade+slide up saat halaman dimuat ── */
        body {
            animation: page-enter 0.42s cubic-bezier(.22,.68,0,1.15) both;
        }
        @keyframes page-enter {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        /* Saat navigating keluar, matikan animasi enter agar tidak bentrok */
        body.is-leaving {
            animation: none !important;
            transition: opacity 0.18s ease, transform 0.18s ease !important;
            opacity: 0 !important;
            transform: translateY(-10px) !important;
        }

        /* ── Scroll Reveal ─────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.5s ease, transform 0.5s cubic-bezier(.22,.68,0,1.2);
        }
        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* Stagger via CSS custom property */
        .reveal:nth-child(2) { transition-delay: 0.07s; }
        .reveal:nth-child(3) { transition-delay: 0.14s; }
        .reveal:nth-child(4) { transition-delay: 0.21s; }

        /* ── Button / Link press ───────────────────────────────── */
        a, button {
            -webkit-tap-highlight-color: transparent;
        }
        .btn-anim {
            transition: transform 0.12s ease, box-shadow 0.12s ease, background-color 0.15s ease;
        }
        .btn-anim:active { transform: scale(0.95) !important; }

        /* ── Ripple effect ─────────────────────────────────────── */
        .rpl { position: relative; overflow: hidden; }
        .rpl-wave {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            background: rgba(255,255,255,0.3);
            animation: rpl-go 0.5s ease-out forwards;
            pointer-events: none;
        }
        @keyframes rpl-go {
            to { transform: scale(5); opacity: 0; }
        }

        /* ── Nav underline slide ───────────────────────────────── */
        .nav-ul a {
            position: relative;
        }
        .nav-ul a::after {
            content: '';
            position: absolute;
            bottom: -3px; left: 50%;
            width: 0; height: 2px;
            background: #16a34a;
            border-radius: 99px;
            transition: width 0.22s ease, left 0.22s ease;
        }
        .nav-ul a:hover::after {
            width: 100%; left: 0;
        }

        /* ── Card hover lift ───────────────────────────────────── */
        .card-lift {
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }
        .card-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px -8px rgba(0,0,0,0.12);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen pb-16 md:pb-0">

    <!-- Topbar Kontak & Jam Pelayanan -->
    <div class="bg-primary-900 text-slate-200 text-[11px] sm:text-xs py-2 px-3 sm:px-4 border-b border-primary-800">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <span><i class="fa-solid fa-location-dot text-emerald-400 mr-1"></i> <span class="hidden sm:inline">Kec. Trimurjo, </span>Kab. Lampung Tengah</span>
                <span class="hidden md:inline"><i class="fa-solid fa-clock text-emerald-400 mr-1"></i> Senin - Jumat (08.00 - 15.00 WIB)</span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('lacak.surat') }}" class="text-emerald-300 hover:text-white font-medium flex items-center">
                    <i class="fa-solid fa-qrcode mr-1"></i> Lacak Status Surat
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-slate-100" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 sm:h-20 items-center">
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2.5 sm:space-x-3 group">
                    <img src="{{ asset('logo-lampung-tengah.png') }}" alt="Logo Kabupaten Lampung Tengah" class="w-9 h-9 sm:w-12 sm:h-12 object-contain drop-shadow-sm group-hover:scale-105 transition-transform duration-200 shrink-0">
                    <div>
                        <span class="text-sm sm:text-xl font-extrabold text-slate-900 tracking-tight block leading-tight group-hover:text-emerald-700 transition-colors">
                            KELURAHAN NOTOHARJO
                        </span>
                        <span class="text-[9px] sm:text-[11px] text-slate-500 font-semibold block tracking-wide">
                            Kecamatan Trimurjo • Lampung Tengah
                        </span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="nav-ul hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600 transition {{ request()->routeIs('home') ? 'text-emerald-600 font-bold' : '' }}">Beranda</a>
                    <a href="{{ route('profil') }}" class="hover:text-emerald-600 transition {{ request()->routeIs('profil') ? 'text-emerald-600 font-bold' : '' }}">Profil & Sejarah</a>
                    <a href="{{ route('potensi.index') }}" class="hover:text-emerald-600 transition {{ request()->routeIs('potensi.*') ? 'text-emerald-600 font-bold' : '' }}">Pasar Welit</a>
                    <a href="{{ route('transparansi.index') }}" class="hover:text-emerald-600 transition {{ request()->routeIs('transparansi.*') ? 'text-emerald-600 font-bold' : '' }}">Transparansi Anggaran</a>
                    <a href="{{ route('agenda.index') }}" class="hover:text-emerald-600 transition {{ request()->routeIs('agenda.*') ? 'text-emerald-600 font-bold' : '' }}">Agenda</a>
                    <a href="{{ route('berita.index') }}" class="hover:text-emerald-600 transition {{ request()->routeIs('berita.*') ? 'text-emerald-600 font-bold' : '' }}">Berita</a>
                    <a href="{{ route('galeri.index') }}" class="hover:text-emerald-600 transition {{ request()->routeIs('galeri.*') ? 'text-emerald-600 font-bold' : '' }}">Galeri</a>
                    <a href="{{ route('pengaduan.publik') }}" class="hover:text-emerald-600 transition {{ request()->routeIs('pengaduan.*') ? 'text-emerald-600 font-bold' : '' }}">Aspirasi Warga</a>
                </div>

                <!-- Action Button -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        @include('partials.notifikasi_bell')

                        @if(Auth::user()->isPegawai())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-sm font-semibold transition flex items-center space-x-2 shadow-sm">
                                <i class="fa-solid fa-gauge-high"></i>
                                <span>Panel Pegawai</span>
                            </a>
                        @else
                            <a href="{{ route('warga.dashboard') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition flex items-center space-x-2 shadow-sm">
                                <i class="fa-solid fa-user-circle"></i>
                                <span>Portal Warga</span>
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition" title="Keluar">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-emerald-600 px-3 py-2">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition shadow-sm shadow-emerald-200">
                            Daftar Warga
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-slate-700 hover:text-emerald-600 w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center transition">
                        <i class="fa-solid fa-bars text-lg" x-show="!open"></i>
                        <i class="fa-solid fa-xmark text-lg" x-show="open"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown (Card Drawer) -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-1 shadow-lg"
             style="display: none;">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-house w-5 text-center text-emerald-600"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('profil') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('profil') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-book-open w-5 text-center text-emerald-600"></i>
                <span>Profil & Sejarah Desa</span>
            </a>
            <a href="{{ route('potensi.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('potensi.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-store w-5 text-center text-emerald-600"></i>
                <span>Pasar Welit</span>
            </a>
            <a href="{{ route('transparansi.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('transparansi.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center text-emerald-600"></i>
                <span>Transparansi Anggaran</span>
            </a>
            <a href="{{ route('agenda.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('agenda.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-calendar-days w-5 text-center text-emerald-600"></i>
                <span>Agenda Kelurahan</span>
            </a>
            <a href="{{ route('berita.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('berita.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-newspaper w-5 text-center text-emerald-600"></i>
                <span>Berita & Kabar Desa</span>
            </a>
            <a href="{{ route('galeri.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('galeri.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-images w-5 text-center text-emerald-600"></i>
                <span>Galeri Foto & Video</span>
            </a>
            <a href="{{ route('pengaduan.publik') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('pengaduan.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-bullhorn w-5 text-center text-emerald-600"></i>
                <span>Aspirasi & Pengaduan Warga</span>
            </a>
            <a href="{{ route('lacak.surat') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('lacak.surat') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-qrcode w-5 text-center text-emerald-600"></i>
                <span>Lacak Status Surat</span>
            </a>

            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                @auth
                    @if(Auth::user()->isPegawai())
                        <a href="{{ route('admin.dashboard') }}" class="w-full text-center py-2.5 bg-slate-900 text-white rounded-xl font-bold text-xs flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>Buka Panel Pegawai</span>
                        </a>
                    @else
                        <a href="{{ route('warga.dashboard') }}" class="w-full text-center py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-xs flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-circle-user"></i>
                            <span>Buka Portal Mandiri Warga</span>
                        </a>
                    @endif
                @else
                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <a href="{{ route('login') }}" class="text-center py-2.5 border border-slate-300 text-slate-800 rounded-xl font-bold text-xs hover:bg-slate-50">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-center py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-xs hover:bg-emerald-700 shadow-sm shadow-emerald-200">
                            Daftar Warga
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center space-x-3 mb-4 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('info'))
            <div class="p-4 bg-sky-50 border border-sky-200 text-sky-800 rounded-xl flex items-center space-x-3 mb-4 shadow-sm">
                <i class="fa-solid fa-circle-info text-sky-500 text-lg"></i>
                <span class="text-sm font-medium">{{ session('info') }}</span>
            </div>
        @endif
        @if(session('error') || $errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-start space-x-3 mb-4 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-rose-500 text-lg mt-0.5"></i>
                <div class="text-sm">
                    @if(session('error'))
                        <div class="font-medium">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('logo-lampung-tengah.png') }}" alt="Logo Kabupaten Lampung Tengah" class="w-12 h-12 object-contain bg-white/10 p-1 rounded-xl shrink-0">
                        <div>
                            <span class="text-lg font-bold text-white block">KELURAHAN NOTOHARJO</span>
                            <span class="text-xs text-slate-400">Kecamatan Trimurjo, Kabupaten Lampung Tengah</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-md">
                        Sistem informasi dan pelayanan administrasi terpadu berbasis digital untuk transparansi, kecepatan pelayanan surat menyurat, dan publikasi potensi pertanian serta Pasar Tradisional Welit.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Layanan Cepat</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('lacak.surat') }}" class="hover:text-emerald-400 transition">Lacak Surat Mandiri</a></li>
                        <li><a href="{{ route('warga.surat.create') }}" class="hover:text-emerald-400 transition">Permohonan Surat Online</a></li>
                        <li><a href="{{ route('potensi.index') }}" class="hover:text-emerald-400 transition">Pasar Tradisional Welit</a></li>
                        <li><a href="{{ route('agenda.index') }}" class="hover:text-emerald-400 transition">Agenda & Kegiatan</a></li>
                        <li><a href="{{ route('transparansi.index') }}" class="hover:text-emerald-400 transition">Transparansi Anggaran</a></li>
                        <li><a href="{{ route('pengaduan.publik') }}" class="hover:text-emerald-400 transition">Kanal Aspirasi Warga</a></li>
                        <li><a href="{{ route('diagram.sistem') }}" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-bold transition flex items-center space-x-1"><span>Diagram Arsitektur Sistem</span><i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-1"></i></a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Wilayah Pemerintahan</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><i class="fa-solid fa-house-chimney text-emerald-500 mr-2"></i>Dusun I: Bedeng 17 Polos</li>
                        <li><i class="fa-solid fa-seedling text-emerald-500 mr-2"></i>Dusun II: Bedeng 17A</li>
                        <li><i class="fa-solid fa-store text-emerald-500 mr-2"></i>Dusun III: Bedeng 18 Polos (Pasar Welit)</li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} Pemerintah Kelurahan Notoharjo. Implementasi Metode SDLC & Laravel.</p>
                <div class="flex space-x-6">
                    <span>Kode Wilayah: 18.02.01</span>
                    <span>Lampung Tengah - Lampung</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom App Bar (Sticky Thumb Navigation) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 shadow-xl px-2 py-1 flex justify-around items-center">
        <a href="{{ route('home') }}" class="flex flex-col items-center py-1 px-2 rounded-xl transition {{ request()->routeIs('home') ? 'text-emerald-600 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
            <i class="fa-solid fa-house text-base"></i>
            <span class="text-[10px] mt-0.5">Beranda</span>
        </a>
        <a href="{{ route('warga.surat.create') }}" class="flex flex-col items-center py-1 px-2 rounded-xl transition {{ request()->routeIs('warga.surat.*') ? 'text-emerald-600 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
            <i class="fa-solid fa-file-pen text-base"></i>
            <span class="text-[10px] mt-0.5">Surat</span>
        </a>
        <a href="{{ route('lacak.surat') }}" class="flex flex-col items-center py-1 px-2 rounded-xl transition {{ request()->routeIs('lacak.surat') ? 'text-emerald-600 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
            <i class="fa-solid fa-qrcode text-base"></i>
            <span class="text-[10px] mt-0.5">Lacak</span>
        </a>
        <a href="{{ route('pengaduan.publik') }}" class="flex flex-col items-center py-1 px-2 rounded-xl transition {{ request()->routeIs('pengaduan.*') ? 'text-emerald-600 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
            <i class="fa-solid fa-bullhorn text-base"></i>
            <span class="text-[10px] mt-0.5">Aspirasi</span>
        </a>
        @auth
            @if(Auth::user()->isPegawai())
                <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center py-1 px-2 rounded-xl transition {{ request()->routeIs('admin.*') ? 'text-emerald-600 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
                    <i class="fa-solid fa-gauge-high text-base text-emerald-600"></i>
                    <span class="text-[10px] mt-0.5 font-bold text-emerald-700">Admin</span>
                </a>
            @else
                <a href="{{ route('warga.dashboard') }}" class="flex flex-col items-center py-1 px-2 rounded-xl transition {{ request()->routeIs('warga.dashboard') ? 'text-emerald-600 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
                    <i class="fa-solid fa-circle-user text-base text-emerald-600"></i>
                    <span class="text-[10px] mt-0.5 font-bold text-emerald-700">Akun</span>
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center py-1 px-2 rounded-xl transition {{ request()->routeIs('login') ? 'text-emerald-600 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
                <i class="fa-solid fa-right-to-bracket text-base"></i>
                <span class="text-[10px] mt-0.5">Masuk</span>
            </a>
        @endauth
    </nav>

    <!-- Animation Scripts -->
    <script>
    (function () {
        'use strict';

        /* ══════════════════════════════════════════════════
           1. PAGE TRANSITION — fade body keluar, masuk
           Body masuk: dianimasikan via CSS (@keyframes page-enter)
           Body keluar: tambah class is-leaving, lalu navigate
        ══════════════════════════════════════════════════ */
        var navigating = false;

        document.addEventListener('click', function (e) {
            if (navigating) { return; }
            var link = e.target.closest('a[href]');
            if (!link) { return; }

            var href = link.getAttribute('href');
            if (!href
                || href === '#'
                || href.startsWith('#')
                || href.startsWith('javascript')
                || href.startsWith('mailto')
                || href.startsWith('tel')
                || link.getAttribute('target') === '_blank'
                || (link.hostname && link.hostname !== location.hostname)
            ) { return; }

            /* Skip form-submit links and Alpine @click links */
            if (link.closest('form')) { return; }

            e.preventDefault();
            navigating = true;

            document.body.style.pointerEvents = 'none';
            document.body.style.transition    = 'opacity 0.18s ease, transform 0.18s ease';
            document.body.style.opacity       = '0';
            document.body.style.transform     = 'translateY(-10px)';

            setTimeout(function () {
                window.location.href = href;
            }, 200);
        });

        /* ══════════════════════════════════════════════════
           2. SCROLL REVEAL
           Hanya tag element dengan class .reveal yang sudah ada
           di template, tidak auto-tag semua div (terlalu agresif)
        ══════════════════════════════════════════════════ */
        var reveals = document.querySelectorAll('.reveal');
        if (reveals.length && 'IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
            reveals.forEach(function (el) { io.observe(el); });
        }

        /* ══════════════════════════════════════════════════
           3. RIPPLE — hanya pada <a> dan <button> yang punya
           background warna (class bg-* dari Tailwind)
        ══════════════════════════════════════════════════ */
        document.querySelectorAll('a[class*="bg-"], button[class*="bg-"]').forEach(function (el) {
            el.classList.add('rpl');
            el.addEventListener('click', function (e) {
                var rect = el.getBoundingClientRect();
                var size = Math.max(rect.width, rect.height) * 1.6;
                var wave = document.createElement('span');
                wave.className = 'rpl-wave';
                wave.style.width  = size + 'px';
                wave.style.height = size + 'px';
                wave.style.left   = (e.clientX - rect.left - size / 2) + 'px';
                wave.style.top    = (e.clientY - rect.top  - size / 2) + 'px';
                el.appendChild(wave);
                wave.addEventListener('animationend', function () { wave.remove(); });
            });
            /* Press scale */
            el.classList.add('btn-anim');
        });

        /* ══════════════════════════════════════════════════
           4. CARD HOVER LIFT — semua card standar
        ══════════════════════════════════════════════════ */
        document.querySelectorAll(
            '.rounded-2xl.bg-white, .rounded-xl.bg-white, .rounded-2xl.border, .rounded-xl.border'
        ).forEach(function (el) {
            /* Jangan lift kalau dia nav atau footer */
            if (el.closest('nav, footer, header')) { return; }
            el.classList.add('card-lift');
        });

        /* ── Progress bar animate on scroll ───────────────── */
        document.querySelectorAll('[data-progress]').forEach(function (bar) {
            var target = bar.getAttribute('data-progress');
            bar.style.width = '0%';
            var io2 = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        setTimeout(function () {
                            bar.style.transition = 'width 0.9s cubic-bezier(.22,.68,0,1.1)';
                            bar.style.width = target;
                        }, 120);
                        io2.unobserve(bar);
                    }
                });
            }, { threshold: 0.5 });
            io2.observe(bar);
        });

    })();
    </script>

</body>
</html>

