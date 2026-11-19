@extends('layouts.app')

@section('title', 'Beranda - Kelurahan Notoharjo, Kecamatan Trimurjo')

@section('content')
<!-- Hero Section -->
<section class="relative text-white overflow-hidden min-h-[560px] flex items-center">
    {{-- Background photo --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/kantor-kelurahan.jpg') }}"
             alt="Kantor Kelurahan Notoharjo"
             class="w-full h-full object-cover object-center">
        {{-- Dark overlay untuk keterbacaan teks --}}
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-emerald-950/70 to-slate-950/50"></div>
    </div>

    {{-- Content --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-24 lg:py-32">
        <div class="max-w-3xl space-y-7">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm text-emerald-300 text-xs font-semibold uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Pelayanan Publik &amp; Informasi Terpadu</span>
            </div>

            {{-- Judul --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1]">
                Portal Layanan Mandiri<br>
                <span class="text-emerald-400">Kelurahan Notoharjo</span>
            </h1>

            {{-- Sub-judul / Tagline --}}
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-xl">
                Kelola administrasi kependudukan secara digital — tanpa antrean, berkas mudah, dan surat resmi berkode QR langsung dari rumah Anda.
            </p>

            {{-- CTA --}}
            <div class="flex flex-wrap gap-3 pt-1">
                <a href="{{ route('warga.surat.create') }}"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold rounded-xl shadow-lg shadow-emerald-500/30 transition-all duration-200 hover:scale-[1.02]">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Ajukan Surat Mandiri</span>
                </a>
                <a href="{{ route('profil') }}"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-white/10 hover:bg-white/20 border border-white/25 backdrop-blur-sm text-white font-semibold rounded-xl transition-all duration-200">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Profil &amp; Sejarah Desa</span>
                </a>
            </div>

            {{-- Info lokasi --}}
            <p class="text-slate-400 text-xs flex items-center gap-1.5 pt-1">
                <i class="fa-solid fa-location-dot text-emerald-400"></i>
                Kecamatan Trimurjo, Kabupaten Lampung Tengah, Provinsi Lampung
            </p>
        </div>
    </div>
</section>

<!-- Statistik Cepat -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="reveal bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <span class="text-2xl font-black text-slate-900">{{ number_format($statistik['total_penduduk'], 0, ',', '.') }}</span>
                <span class="block text-xs text-slate-500 font-medium">Total Penduduk (Jiwa)</span>
            </div>
        </div>

        <div class="reveal bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-address-card"></i>
            </div>
            <div>
                <span class="text-2xl font-black text-slate-900">{{ number_format($statistik['total_kk'], 0, ',', '.') }}</span>
                <span class="block text-xs text-slate-500 font-medium">Kepala Keluarga (KK)</span>
            </div>
        </div>

        <div class="reveal bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div>
                <span class="text-2xl font-black text-slate-900">{{ $statistik['total_dusun'] }} Dusun</span>
                <span class="block text-xs text-slate-500 font-medium">17 Polos, 17A, 18 Polos</span>
            </div>
        </div>

        <div class="reveal bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <span class="text-2xl font-black text-slate-900">{{ number_format($statistik['surat_selesai']) }}</span>
                <span class="block text-xs text-slate-500 font-medium">Surat Diterbitkan</span>
            </div>
        </div>
    </div>
</section>

<!-- Layanan Administrasi Surat Mandiri -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">Pelayanan Digital</h2>
        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Layanan Surat Menyurat Online</h3>
        <p class="text-slate-600 mt-3 text-sm leading-relaxed">
            Warga Notoharjo dapat mengajukan permohonan surat administrasi resmi dari rumah tanpa antre. Berkas diverifikasi bertingkat dari Kasi Pelayanan, Sekretaris, hingga disahkan Lurah.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($daftarLayanan as $layanan)
            <div class="reveal bg-white rounded-2xl p-6 border border-slate-200/80 hover:border-emerald-500 hover:shadow-xl transition group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-400">KODE {{ $layanan->kode_klasifikasi }}</span>
                    <h4 class="text-base font-bold text-slate-900 mt-1 mb-2">{{ $layanan->nama_surat }}</h4>
                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-4">
                        {{ $layanan->deskripsi }}
                    </p>
                    
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs text-slate-600 space-y-1 mb-6">
                        <span class="font-semibold block text-slate-700">Syarat Berkas:</span>
                        @foreach($layanan->syaratSurat as $syarat)
                            <div class="flex items-center space-x-1.5 text-slate-500">
                                <i class="fa-solid fa-check text-emerald-500 text-[10px]"></i>
                                <span class="truncate">{{ $syarat->nama_syarat }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('warga.surat.create', ['kode' => $layanan->id_kode_surat]) }}" class="w-full text-center py-2.5 bg-emerald-50 group-hover:bg-emerald-600 group-hover:text-white text-emerald-700 font-bold rounded-xl text-xs transition">
                    Ajukan Sekarang
                </a>
            </div>
        @endforeach
    </div>
</section>

<!-- Ikon Pasar Tradisional Welit (Desa 18 Polos) -->
<section class="bg-slate-100/70 py-16 sm:py-20 border-y border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="grid grid-cols-1 lg:grid-cols-12 items-center">
                <!-- Foto Pasar Welit -->
                <div class="lg:col-span-5 relative overflow-hidden aspect-video lg:aspect-auto lg:h-full min-h-[300px] sm:min-h-[360px] bg-slate-900 group">
                    <img src="{{ asset('pasar-welit.jpg') }}" alt="Pasar Tradisional Welit Notoharjo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent lg:hidden"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white lg:hidden">
                        <span class="text-[10px] px-2.5 py-1 bg-emerald-600 rounded-full font-bold uppercase tracking-wider inline-block mb-1">Pasar Tradisional</span>
                        <h4 class="font-extrabold text-base">Pasar Tradisional Welit (Desa 18 Polos)</h4>
                    </div>
                </div>

                <!-- Konten Profil Pasar Welit -->
                <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 space-y-5">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider">
                        <i class="fa-solid fa-store mr-1 text-emerald-600"></i> Ikon Perdagangan Bersejarah Sejak 1937
                    </div>
                    
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Pasar Tradisional Welit <span class="text-emerald-700">(Desa 18 Polos)</span>
                    </h3>

                    <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                        Pasar Welit berakar dari masa awal pembukaan lahan kolonisasi/transmigrasi tahun 1937, di mana para perintis mendirikan pasar penampungan beratap ilalang liar (<em>Welit</em>). Hingga kini menjadi pusat denyut nadi perdagangan hasil panen bumi, sayur-mayur segar, sembako, dan kebutuhan pokok bagi masyarakat Notoharjo se-Kecamatan Trimurjo.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-600 pt-1">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-location-dot text-emerald-600"></i>
                            <span>Bedeng 18 Polos (Mengger Rejo)</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-clock text-emerald-600"></i>
                            <span>Pasaran Pagi (05.30 - 11.00 WIB)</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-users text-emerald-600"></i>
                            <span>Paguyuban Pedagang & Kelurahan</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-calendar-check text-emerald-600"></i>
                            <span>Berdiri Sejak 1937</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-4 items-center">
                        <a href="{{ route('potensi.index') }}" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold rounded-xl transition shadow-md shadow-emerald-600/20 flex items-center space-x-2">
                            <span>Jelajahi Profil Lengkap Pasar Welit</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Transparansi Anggaran Kelurahan -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-5 space-y-5">
            <div class="inline-flex items-center space-x-2 px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider">
                <i class="fa-solid fa-chart-pie mr-1"></i> Transparansi Publik
            </div>
            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Keterbukaan Dana & Anggaran Kelurahan Notoharjo TA 2026
            </h3>
            <p class="text-slate-600 text-sm leading-relaxed">
                Sebagai wujud tata kelola pemerintahan yang akuntabel sesuai amanat undang-undang dan riset transparansi, kami mempublikasikan alokasi Dana Kelurahan untuk pembangunan jalan, infrastruktur pertanian, dan pemberdayaan warga.
            </p>
            <div class="pt-2">
                <a href="{{ route('transparansi.index') }}" class="px-5 py-3 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition inline-flex items-center space-x-2">
                    <span>Lihat Laporan Lengkap APBD</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <div class="lg:col-span-7 space-y-4">
            @foreach($transparansiList as $ang)
                <div class="reveal bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $ang->jenis === 'Pendapatan' ? 'bg-sky-100 text-sky-800' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ $ang->jenis }}
                            </span>
                            <h4 class="font-bold text-slate-900 text-sm mt-1">{{ $ang->uraian }}</h4>
                            <span class="text-xs text-slate-500">{{ $ang->bidang }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-slate-400 block">Realisasi</span>
                            <span class="text-sm font-extrabold text-emerald-600">
                                Rp {{ number_format($ang->realisasi_anggaran, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <!-- Progress Bar -->
                    @php
                        $persen = $ang->target_anggaran > 0 ? min(100, round(($ang->realisasi_anggaran / $ang->target_anggaran) * 100)) : 100;
                    @endphp
                    <div class="w-full bg-slate-100 rounded-full h-2 mt-3 overflow-hidden">
                        <div class="bg-emerald-500 h-2 rounded-full" data-progress="{{ $persen }}%" style="width: 0%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 mt-1">
                        <span>Pagu: Rp {{ number_format($ang->target_anggaran, 0, ',', '.') }}</span>
                        <span class="font-semibold text-slate-600">{{ $persen }}% Tercapai</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Berita & Agenda Terbaru -->
<section class="bg-slate-50 py-20 border-t border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <h2 class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-1">Kabar Desa</h2>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Berita & Informasi Terkini</h3>
            </div>
            <a href="{{ route('berita.index') }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-800 flex items-center space-x-1">
                <span>Indeks Berita</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($beritaTerbaru as $b)
                <article class="reveal bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col justify-between hover:shadow-lg transition group">
                    <div>
                        @if($b->gambar)
                            <div class="aspect-video overflow-hidden bg-slate-100">
                                <img src="{{ Str::startsWith($b->gambar, ['http://', 'https://']) ? $b->gambar : asset($b->gambar) }}" 
                                     alt="{{ $b->judul }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     loading="lazy">
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-3">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ $b->created_at->translatedFormat('d F Y') }}</span>
                                <span>•</span>
                                <span>{{ $b->views }}x dibaca</span>
                            </div>
                            <h4 class="text-base font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition">
                                <a href="{{ route('berita.detail', $b->slug) }}">{{ $b->judul }}</a>
                            </h4>
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                {{ $b->ringkasan }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 pb-6 pt-2 border-t border-slate-100">
                        <a href="{{ route('berita.detail', $b->slug) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center space-x-1">
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Agenda Kegiatan Kelurahan -->
@if(isset($agendaMendatang) && $agendaMendatang->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Jadwal Komunitas & Desa</span>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Agenda Kegiatan Mendatang</h3>
        </div>
        <a href="{{ route('agenda.index') }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-800 flex items-center space-x-1">
            <span>Lihat Semua Kalender</span>
            <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($agendaMendatang as $ag)
            <div class="reveal bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="px-3.5 py-2.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-center shrink-0">
                            <span class="block text-2xl font-black leading-none">{{ $ag->tanggal_mulai->format('d') }}</span>
                            <span class="block text-[10px] font-bold uppercase mt-1">{{ $ag->tanggal_mulai->translatedFormat('M Y') }}</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 truncate max-w-[150px]">
                            {{ $ag->penyelenggara ?? 'Kelurahan Notoharjo' }}
                        </span>
                    </div>

                    <div>
                        <h4 class="font-bold text-slate-900 text-base group-hover:text-emerald-600 transition leading-snug">
                            {{ $ag->nama_kegiatan }}
                        </h4>
                        <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">
                            {{ $ag->deskripsi }}
                        </p>
                    </div>

                    <div class="space-y-1.5 text-xs text-slate-500 pt-2 border-t border-slate-100">
                        <div class="flex items-center space-x-2">
                            <i class="fa-regular fa-clock text-emerald-600 w-4"></i>
                            <span>{{ $ag->tanggal_mulai->format('H:i') }} WIB</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-location-dot text-rose-500 w-4"></i>
                            <span class="truncate">{{ $ag->lokasi }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span class="text-emerald-600 font-semibold">{{ $ag->tanggal_mulai->diffForHumans() }}</span>
                    <a href="{{ route('agenda.index') }}" class="font-bold text-slate-700 hover:text-emerald-600">Detail &rarr;</a>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif
@endsection

