@extends('layouts.app')

@section('title', 'Pasar Tradisional Welit (Desa 18 Polos) - Kelurahan Notoharjo')

@section('content')
<!-- Hero Header dengan Background Foto Asli Pasar Welit -->
<section class="relative bg-slate-950 text-white py-16 sm:py-24 lg:py-28 overflow-hidden">
    <!-- Background Image dengan Gradient Overlay -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="{{ asset('pasar-welit.jpg') }}" alt="Suasana Pasar Tradisional Welit Notoharjo" class="w-full h-full object-cover object-center filter brightness-[0.52] contrast-105 saturate-105">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-emerald-950/40"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-transparent via-slate-950/20 to-slate-950/60"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl space-y-5">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-bold uppercase tracking-wider backdrop-blur-md">
                <i class="fa-solid fa-store text-emerald-400"></i>
                <span>Ikon Perdagangan Bersejarah Sejak 1937</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight text-white drop-shadow-md">
                Pasar Tradisional Welit <span class="text-emerald-400 block sm:inline">(Desa 18 Polos)</span>
            </h1>

            <p class="text-slate-200 text-sm sm:text-base leading-relaxed max-w-2xl font-normal drop-shadow">
                Pusat denyut nadi perekonomian rakyat Kelurahan Notoharjo. Berdiri sejak awal masa transmigrasi/kolonisasi 1937 dengan ciri khas atap ilalang liar (<em>Welit</em>), kini menjadi sentra transaksi sayur-mayur, hasil panen bumi, dan kebutuhan pokok bagi masyarakat Notoharjo hingga se-Kecamatan Trimurjo.
            </p>

            <div class="flex flex-wrap gap-2.5 sm:gap-3 pt-2 text-xs sm:text-sm">
                <span class="inline-flex items-center px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-slate-100 font-medium">
                    <i class="fa-solid fa-location-dot text-emerald-400 mr-2"></i> Bedeng 18 Polos (Mengger Rejo)
                </span>
                <span class="inline-flex items-center px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-slate-100 font-medium">
                    <i class="fa-solid fa-clock text-amber-400 mr-2"></i> Pasaran Pagi (05.30 - 11.00 WIB)
                </span>
                <span class="inline-flex items-center px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-slate-100 font-medium">
                    <i class="fa-solid fa-users text-sky-400 mr-2"></i> Paguyuban Pedagang & Kelurahan
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Konten Utama Pasar Welit -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 space-y-12">
    <!-- Sejarah & Asal Usul Nama Welit + Visual Box -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-7 space-y-5">
            <div class="inline-flex items-center space-x-2 text-xs font-bold text-amber-700 bg-amber-50 px-3 py-1 rounded-lg border border-amber-200/80 uppercase tracking-wider">
                <i class="fa-solid fa-landmark"></i>
                <span>Napak Tilas Sejarah 1937</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Dari Atap Ilalang Liar Menjadi Urat Nadi Perdagangan
            </h2>
            <div class="space-y-4 text-slate-600 text-sm sm:text-base leading-relaxed">
                <p>
                    Pasar Welit memiliki nilai historis yang melekat erat dengan awal pembukaan permukiman Notoharjo pada era transmigrasi/kolonisasi tahun <strong>1937</strong>. Pada masa tersebut, para perintis mendirikan pasar penampungan sementara menggunakan naungan dari anyaman daun ilalang liar yang dalam bahasa Jawa disebut sebagai <em><strong>Welit</strong></em>.
                </p>
                <p>
                    Seiring waktu, pasar ini terus bertahan dan berkembang menjadi pusat transaksi hasil tani, palawija, sayuran segar, dan sembako terbesar bagi warga Notoharjo, Simbarwaringin, Pujodadi, dan sekitarnya. Karakter pasar yang ramah, guyub rukun, dan harga yang langsung dari tangan petani menjadikannya primadona belanja harian masyarakat.
                </p>
            </div>

            <!-- Quick Fact Counter -->
            <div class="grid grid-cols-3 gap-3 sm:gap-4 pt-4 border-t border-slate-200">
                <div class="bg-slate-50 p-3.5 sm:p-4 rounded-2xl border border-slate-100 text-center">
                    <span class="text-xl sm:text-2xl font-black text-emerald-700 block">1937</span>
                    <span class="text-[11px] sm:text-xs text-slate-500 font-medium">Tahun Berdiri</span>
                </div>
                <div class="bg-slate-50 p-3.5 sm:p-4 rounded-2xl border border-slate-100 text-center">
                    <span class="text-xl sm:text-2xl font-black text-emerald-700 block">18 Polos</span>
                    <span class="text-[11px] sm:text-xs text-slate-500 font-medium">Lokasi Bedeng</span>
                </div>
                <div class="bg-slate-50 p-3.5 sm:p-4 rounded-2xl border border-slate-100 text-center">
                    <span class="text-xl sm:text-2xl font-black text-emerald-700 block">100+</span>
                    <span class="text-[11px] sm:text-xs text-slate-500 font-medium">Pedagang Aktif</span>
                </div>
            </div>
        </div>

        <!-- Kartu Dokumentasi Foto Pasar Welit -->
        <div class="lg:col-span-5">
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-200 group">
                <div class="relative overflow-hidden aspect-[4/3]">
                    <img src="{{ asset('pasar-welit.jpg') }}" alt="Dokumentasi Pasar Tradisional Welit Notoharjo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute bottom-3 left-3 right-3 bg-slate-900/80 backdrop-blur-md text-white p-3 rounded-xl text-xs">
                        <div class="font-bold flex items-center">
                            <i class="fa-solid fa-camera mr-1.5 text-emerald-400"></i> Suasana Los Pedagang Pasar Welit
                        </div>
                        <p class="text-[11px] text-slate-300 mt-0.5">Tenda terpal khas pedagang sayur dan komoditas pangan segar harian.</p>
                    </div>
                </div>
                <div class="p-5 bg-gradient-to-br from-emerald-50/50 to-white">
                    <div class="flex items-center justify-between text-xs text-slate-600">
                        <span><i class="fa-solid fa-map-pin text-emerald-600 mr-1.5"></i> Dusun III (Bedeng 18 Polos)</span>
                        <span class="font-semibold text-emerald-700"><i class="fa-solid fa-circle-check mr-1 text-emerald-500"></i> Beroperasi Rutin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keunggulan & Daya Tarik Pasar Welit -->
    <div class="space-y-6 pt-6">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest block">Daya Tarik & Komoditas</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Mengapa Berbelanja di Pasar Tradisional Welit?
            </h3>
            <p class="text-xs sm:text-sm text-slate-600">
                Kelebihan dan keaslian transaksi perdagangan tradisional yang terus dijaga oleh masyarakat Notoharjo
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition space-y-3">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-carrot"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base">Sayur & Hasil Bumi Segar</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Dipasok langsung dari sawah dan kebun petani lokal Notoharjo setiap subuh sehingga terjamin kesegaran dan mutunya.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition space-y-3">
                <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base">Harga Terjangkau & Grosir</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Rantai distribusi pendek membuat harga bahan pangan pokok, cabai, bawang, dan rempah jauh lebih bersahabat dan ramah kantong.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition space-y-3">
                <div class="w-12 h-12 bg-sky-100 text-sky-700 rounded-xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-bowl-food"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base">Jajanan Pasar Tradisional</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Menyajikan jajanan pasar legendaris tempo dulu: tiwul, getuk lindri, cenil, urap, pecel pincuk, dan aneka gorengan hangat.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition space-y-3">
                <div class="w-12 h-12 bg-purple-100 text-purple-700 rounded-xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-handshake-simple"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base">Guyub Rukun & Ramah</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Suasana transaksi yang hangat dengan interaksi ramah khas pedesaan, menjadi ruang temu silaturahmi antarwarga bedeng.
                </p>
            </div>
        </div>
    </div>

    <!-- Galeri Suasana & Aktivitas Pasar Tradisional Welit (4 Foto Dokumentasi Lapangan) -->
    <div class="space-y-6 pt-4" x-data="{ lightbox: null }">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest block">Dokumentasi Lapangan</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Suasana & Aktivitas Pasar Welit
                </h3>
            </div>
            <p class="text-xs text-slate-500 max-w-md sm:text-right">
                Potret langsung denyut nadi jual-beli, komoditas hasil bumi segar, dan interaksi hangat para pedagang Bedeng 18 Polos.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Foto 1 -->
            <div class="group bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between cursor-pointer"
                 @click="lightbox = { src: '{{ asset('images/pasar-welit/pasar-welit-1.jpg') }}', title: 'Aktivitas Pedagang Pasar Welit', desc: 'Pedagang menata aneka sayur dan kebutuhan pangan harian di bawah tenda terpal khas Pasar Welit.' }">
                <div class="relative overflow-hidden aspect-[4/3] bg-slate-900">
                    <img src="{{ asset('images/pasar-welit/pasar-welit-1.jpg') }}" alt="Aktivitas Pedagang Pasar Welit" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white text-xs font-bold flex items-center space-x-1.5">
                            <i class="fa-solid fa-expand text-emerald-400"></i>
                            <span>Perbesar Foto</span>
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 block mb-1">Los Pedagang</span>
                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-emerald-700 transition">Aktivitas Jual-Beli Pagi</h4>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">Pedagang menata aneka sayur mayur dan kebutuhan pokok harian.</p>
                </div>
            </div>

            <!-- Foto 2 -->
            <div class="group bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between cursor-pointer"
                 @click="lightbox = { src: '{{ asset('images/pasar-welit/pasar-welit-2.jpg') }}', title: 'Komoditas Sayur Mayur Segar', desc: 'Pasokan sayur mayur segar hasil panen petani persawahan dan perkebunan Notoharjo.' }">
                <div class="relative overflow-hidden aspect-[4/3] bg-slate-900">
                    <img src="{{ asset('images/pasar-welit/pasar-welit-2.jpg') }}" alt="Komoditas Sayur Mayur Segar" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white text-xs font-bold flex items-center space-x-1.5">
                            <i class="fa-solid fa-expand text-emerald-400"></i>
                            <span>Perbesar Foto</span>
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 block mb-1">Hasil Bumi</span>
                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-emerald-700 transition">Sayuran Segar Petani</h4>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">Pasokan segar dari kebun dan sawah warga Notoharjo setiap subuh.</p>
                </div>
            </div>

            <!-- Foto 3 -->
            <div class="group bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between cursor-pointer"
                 @click="lightbox = { src: '{{ asset('images/pasar-welit/pasar-welit-3.jpg') }}', title: 'Suasana Los Pasar Tradisional', desc: 'Lorong pasar yang selalu ramai dikunjungi warga Trimurjo dan sekitarnya setiap pagi.' }">
                <div class="relative overflow-hidden aspect-[4/3] bg-slate-900">
                    <img src="{{ asset('images/pasar-welit/pasar-welit-3.jpg') }}" alt="Suasana Los Pasar Tradisional" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white text-xs font-bold flex items-center space-x-1.5">
                            <i class="fa-solid fa-expand text-emerald-400"></i>
                            <span>Perbesar Foto</span>
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 block mb-1">Lorong Dagang</span>
                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-emerald-700 transition">Suasana Los Tradisional</h4>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">Interaksi hangat antara pedagang dan pembeli khas pasar rakyat.</p>
                </div>
            </div>

            <!-- Foto 4 -->
            <div class="group bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between cursor-pointer"
                 @click="lightbox = { src: '{{ asset('images/pasar-welit/pasar-welit-4.jpg') }}', title: 'Sentra Pangan & Palawija', desc: 'Pusat belanja pangan terjangkau untuk kebutuhan rumah tangga dan pedagang kuliner.' }">
                <div class="relative overflow-hidden aspect-[4/3] bg-slate-900">
                    <img src="{{ asset('images/pasar-welit/pasar-welit-4.jpg') }}" alt="Sentra Pangan & Palawija" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white text-xs font-bold flex items-center space-x-1.5">
                            <i class="fa-solid fa-expand text-emerald-400"></i>
                            <span>Perbesar Foto</span>
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 block mb-1">Pangan Rakyat</span>
                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-emerald-700 transition">Sentra Sembako & Sayur</h4>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">Pilihan utama belanja hemat bagi masyarakat se-Kecamatan Trimurjo.</p>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal Fullscreen -->
        <div x-show="lightbox" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="lightbox = null"
             class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-8"
             style="display: none;"
             @click.self="lightbox = null">
            
            <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-slate-800 flex flex-col">
                <div class="flex items-center justify-between p-4 sm:p-5 border-b border-slate-800">
                    <div>
                        <h4 class="text-white font-bold text-sm sm:text-base" x-text="lightbox ? lightbox.title : ''"></h4>
                        <p class="text-xs text-slate-400 mt-0.5" x-text="lightbox ? lightbox.desc : ''"></p>
                    </div>
                    <button type="button" @click="lightbox = null" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>
                <div class="p-2 sm:p-4 bg-black/50 flex items-center justify-center max-h-[75vh] overflow-hidden">
                    <img :src="lightbox ? lightbox.src : ''" :alt="lightbox ? lightbox.title : ''" class="max-h-[70vh] w-auto object-contain rounded-2xl shadow-lg">
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Operasional, Fasilitas & Kontak -->
    <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-10 shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white text-9xl pointer-events-none">
            <i class="fa-solid fa-shop"></i>
        </div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-4">
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest block">Panduan Pengunjung & Pedagang</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Informasi Operasional Pasar Welit</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm text-slate-300 pt-2">
                    <div class="flex items-start space-x-3">
                        <i class="fa-solid fa-calendar-day text-emerald-400 mt-1"></i>
                        <div>
                            <strong class="text-white block">Hari Operasional:</strong>
                            Buka setiap hari, ramai pasaran setiap pagi
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fa-solid fa-clock text-amber-400 mt-1"></i>
                        <div>
                            <strong class="text-white block">Jam Buka:</strong>
                            05.30 - 11.00 WIB (Puncak keramaian: 06.00 - 08.30 WIB)
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fa-solid fa-map-location-dot text-sky-400 mt-1"></i>
                        <div>
                            <strong class="text-white block">Alamat / Lokasi:</strong>
                            Bedeng 18 Polos (Mengger Rejo), Dusun III, Kelurahan Notoharjo, Kec. Trimurjo, Kab. Lampung Tengah
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fa-solid fa-user-shield text-purple-400 mt-1"></i>
                        <div>
                            <strong class="text-white block">Pengelola:</strong>
                            Pemerintah Kelurahan Notoharjo & Paguyuban Pedagang Pasar Welit
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 flex flex-col justify-center space-y-3">
                <a href="{{ route('pengaduan.publik') }}" class="w-full text-center py-3.5 px-6 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold rounded-xl shadow-lg transition text-xs sm:text-sm flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Kirim Saran / Pengaduan Pasar</span>
                </a>
                <a href="{{ route('profil') }}" class="w-full text-center py-3.5 px-6 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold rounded-xl transition text-xs sm:text-sm flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Lihat Sejarah Bedeng Notoharjo</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
