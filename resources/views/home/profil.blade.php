@extends('layouts.app')

@section('title', 'Profil & Sejarah - Kelurahan Notoharjo')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Profil & Sejarah Kelurahan Notoharjo</h1>
        <p class="text-emerald-200 mt-2 text-sm sm:text-base">Kecamatan Trimurjo, Kabupaten Lampung Tengah, Provinsi Lampung</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">
    <!-- Sejarah Singkat -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm">
        <div class="inline-flex items-center space-x-2 px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider mb-4">
            <i class="fa-solid fa-hourglass-start mr-1"></i> Asal Usul
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-6">Sejarah Berdirinya Kelurahan Notoharjo</h2>
        
        <div class="prose max-w-none text-slate-600 text-sm sm:text-base leading-relaxed space-y-4">
            <p>
                Kelurahan Notoharjo semula merupakan hutan belantara yang dibuka pada masa penjajahan Belanda melalui program kolonisasi (transmigrasi) pada tahun <strong>1936</strong>. Penduduk awal berasal dari Jawa Tengah serta Jawa Timur yang mula-mula ditempatkan di Pringsewu, kemudian diberangkatkan ke kawasan hutan yang ditampung dalam pemukiman darurat (bedeng).
            </p>
            <p>
                Pada rentang tahun <strong>1937 sampai 1938</strong>, pemerintah Hindia Belanda menambah kembali gelombang transmigran dari Pulau Jawa. Sejak saat itu berdirilah 3 (tiga) Bedeng pemukiman yang dikepalai oleh masing-masing Kepala Bedeng (sekarang disebut Kepala Dusun):
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
                <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="text-xs font-bold text-emerald-700 block uppercase">Dusun I</span>
                    <h3 class="text-lg font-bold text-slate-900 mt-1">Bedeng 17 Polos</h3>
                    <p class="text-xs text-slate-600 mt-1">Dikenal sebagai <em>Nambah Rejo</em>, merupakan pusat pemerintahan balai kelurahan.</p>
                </div>
                <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="text-xs font-bold text-emerald-700 block uppercase">Dusun II</span>
                    <h3 class="text-lg font-bold text-slate-900 mt-1">Bedeng 17A</h3>
                    <p class="text-xs text-slate-600 mt-1">Dikenal sebagai <em>Nunggal Rejo</em>, sentra pertanian dan lumbung persawahan produktif.</p>
                </div>
                <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="text-xs font-bold text-emerald-700 block uppercase">Dusun III</span>
                    <h3 class="text-lg font-bold text-slate-900 mt-1">Bedeng 18 Polos (Pasar Welit)</h3>
                    <p class="text-xs text-slate-600 mt-1">Dikenal sebagai <em>Mengger Rejo</em>. Di sini didirikan pusat pasar barter tradisional beratap ilalang liar (<strong>Welit</strong>).</p>
                </div>
            </div>
            <p>
                Dari ketiga dusun tersebut, pada tahun <strong>1939</strong> secara resmi dikukuhkan menjadi satu kesatuan pemerintahan desa dengan Kepala Desa pertama yaitu <strong>Bapak Harjo Diwarno</strong>. Total luas wilayah mencapai 477,25 Ha, dengan luas lahan pertanian 317,43 Ha.
            </p>
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-5 bg-gradient-to-br from-emerald-800 to-slate-900 text-white rounded-3xl p-8 sm:p-10 flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest block mb-2">Visi Kelurahan</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold leading-snug">
                    "Terwujudnya Kelurahan Notoharjo sebagai kelurahan yang mandiri berbasis pertanian, dalam mencapai masyarakat yang sehat, cerdas dan lebih sejahtera."
                </h3>
            </div>
            <div class="pt-8 text-xs text-emerald-300">
                Pemerintah Kelurahan Notoharjo • Kecamatan Trimurjo
            </div>
        </div>

        <div class="lg:col-span-7 bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-sm space-y-6">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest block">Misi Kerja</span>
            <div class="space-y-4">
                <div class="flex items-start space-x-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                        1
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed font-medium">
                        Meningkatkan pembangunan infrastruktur yang mendukung perekonomian Kelurahan Notoharjo, seperti jalan usaha tani, jembatan, gorong-gorong serta infrastruktur publik lainnya.
                    </p>
                </div>

                <div class="flex items-start space-x-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                        2
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed font-medium">
                        Meningkatkan pembangunan di bidang kesehatan untuk mendorong derajat kesehatan masyarakat Notoharjo menjadi sehat mandiri dan memiliki umur harapan hidup yang lebih panjang.
                    </p>
                </div>

                <div class="flex items-start space-x-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                        3
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed font-medium">
                        Meningkatkan pembangunan di bidang pendidikan dalam mendorong peningkatan kualitas sumber daya manusia agar memiliki kecerdasan dan daya saing yang lebih baik.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Lambang Daerah & Makna Simbol -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-4 flex flex-col items-center justify-center p-6 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                <img src="{{ asset('logo-lampung-tengah.png') }}" alt="Lambang Daerah Kabupaten Lampung Tengah - Jurai Siwo" class="w-44 h-56 object-contain drop-shadow-lg mb-4">
                <span class="text-xs font-mono font-bold text-slate-800 uppercase tracking-widest">Lambang Daerah Resmi</span>
                <span class="text-xs text-emerald-700 font-bold mt-1">Kabupaten Lampung Tengah</span>
            </div>

            <div class="lg:col-span-8 space-y-4">
                <div class="inline-flex items-center space-x-2 px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider">
                    <i class="fa-solid fa-shield-halved mr-1"></i> Identitas & Falsafah
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                    Semboyan "JURAI SIWO" & Makna Lambang
                </h2>
                <p class="text-sm text-slate-600 leading-relaxed text-justify">
                    Lambang daerah Kabupaten Lampung Tengah memuat semboyan <strong>"JURAI SIWO"</strong> yang bermakna persatuan sembilan kebuayan/marga adat yang hidup rukun berdampingan dengan masyarakat pendatang (transmigran) dalam bingkai persaudaraan yang kokoh.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-xs text-slate-700">
                    <div class="p-3 bg-emerald-50/60 rounded-xl border border-emerald-100 flex items-start space-x-2.5">
                        <i class="fa-solid fa-wheat-awn text-emerald-600 mt-0.5 text-sm"></i>
                        <div>
                            <strong class="block text-slate-900 font-bold">Padi dan Kapas</strong>
                            <span>Melambangkan kemakmuran sandang dan pangan serta keunggulan sektor agraris pertanian di Notoharjo.</span>
                        </div>
                    </div>
                    <div class="p-3 bg-emerald-50/60 rounded-xl border border-emerald-100 flex items-start space-x-2.5">
                        <i class="fa-solid fa-umbrella text-emerald-600 mt-0.5 text-sm"></i>
                        <div>
                            <strong class="block text-slate-900 font-bold">Payung Keagungan</strong>
                            <span>Simbol perlindungan, pengayoman adat, keteduhan hukum, dan keadilan bagi seluruh warga masyarakat.</span>
                        </div>
                    </div>
                    <div class="p-3 bg-emerald-50/60 rounded-xl border border-emerald-100 flex items-start space-x-2.5">
                        <i class="fa-solid fa-chair text-emerald-600 mt-0.5 text-sm"></i>
                        <div>
                            <strong class="block text-slate-900 font-bold">Pepadun / Singgasana Adat</strong>
                            <span>Menggambarkan musyawarah mufakat, kehormatan martabat, dan kearifan budaya luhur Lampung.</span>
                        </div>
                    </div>
                    <div class="p-3 bg-emerald-50/60 rounded-xl border border-emerald-100 flex items-start space-x-2.5">
                        <i class="fa-solid fa-scroll text-emerald-600 mt-0.5 text-sm"></i>
                        <div>
                            <strong class="block text-slate-900 font-bold">Pita Jurai Siwo</strong>
                            <span>Pengikat persatuan masyarakat multikultur (Jawa transmigran dan suku asli Lampung) yang harmonis.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Struktur Organisasi & Aparat Kelurahan -->
    <section class="bg-white rounded-3xl p-6 sm:p-12 border border-slate-200 shadow-sm">
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest block mb-1">Tata Pamong</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Struktur Organisasi Pemerintahan</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-2">Aparat Kelurahan Notoharjo, Kecamatan Trimurjo, Lampung Tengah</p>
        </div>

        <!-- 1. Pimpinan Paling Atas: Kepala Kelurahan (Lurah / Kepala Kampung) -->
        <div class="flex justify-center mb-8 sm:mb-10 relative">
            <div class="w-full max-w-sm p-6 sm:p-8 rounded-3xl bg-gradient-to-b from-emerald-50 via-white to-white border-2 border-emerald-500/50 shadow-xl shadow-emerald-500/10 text-center space-y-3 relative group hover:-translate-y-1 transition duration-300">
                <div class="relative w-28 h-28 sm:w-36 sm:h-36 mx-auto">
                    <img src="{{ asset('kepala-kampung.png') }}" alt="Bambang Sungkowo - Kepala Kelurahan Notoharjo" class="w-full h-full object-cover object-top rounded-full border-4 border-white shadow-lg ring-4 ring-emerald-500/30">
                    <span class="absolute bottom-1 right-1 w-7 h-7 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xs shadow-md" title="Pimpinan Utama">
                        <i class="fa-solid fa-star text-[11px]"></i>
                    </span>
                </div>
                <div>
                    <span class="inline-block text-[11px] font-extrabold px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full uppercase tracking-wider mb-1.5">
                        Kepala Kelurahan (Lurah)
                    </span>
                    <h3 class="font-black text-slate-900 text-lg sm:text-xl">Bambang Sungkowo</h3>
                    <p class="text-xs text-slate-500 font-medium">Pemimpin Pemerintahan & Pelayanan Notoharjo</p>
                </div>
            </div>
        </div>

        <!-- Garis Hirarki Organisasi (Desktop & Tablet) -->
        <div class="hidden sm:flex flex-col items-center justify-center -mt-4 mb-8">
            <div class="w-0.5 h-6 bg-emerald-400"></div>
            <div class="px-3.5 py-1 bg-slate-100 text-[10px] font-bold text-slate-600 uppercase tracking-widest rounded-full border border-slate-200">
                Sekretariat & Perangkat Kelurahan
            </div>
            <div class="w-0.5 h-6 bg-emerald-400"></div>
        </div>

        <!-- 2. Jajaran di Bawah Kepala Kelurahan -->
        <!-- Sekretaris Kelurahan (Di Tengah) -->
        <div class="flex justify-center mb-8">
            <div class="w-full max-w-xs p-5 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm text-center space-y-2 hover:bg-white hover:shadow-md transition">
                <div class="w-14 h-14 bg-slate-800 text-white rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div>
                    <span class="text-xs px-2.5 py-0.5 bg-slate-200 text-slate-800 rounded-full font-bold inline-block mb-1">Sekretaris Kelurahan</span>
                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">Muhammad Mahfud, S.Pd.I</h4>
                </div>
            </div>
        </div>

        <!-- Kasi, Kaur, dan Kepala Dusun (Grid 2 Kolom Tablet, 3 Kolom Desktop) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2 hover:bg-white hover:shadow-md transition">
                <div class="w-14 h-14 bg-sky-600 text-white rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div>
                    <span class="text-xs px-2.5 py-0.5 bg-sky-100 text-sky-800 rounded-full font-semibold inline-block mb-1">Kasi Pelayanan</span>
                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">Karni Hanani, S.E</h4>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2 hover:bg-white hover:shadow-md transition">
                <div class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                    <i class="fa-solid fa-landmark-flag"></i>
                </div>
                <div>
                    <span class="text-xs px-2.5 py-0.5 bg-indigo-100 text-indigo-800 rounded-full font-semibold inline-block mb-1">Kasi Pemerintahan</span>
                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">Suparmin, S.E</h4>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2 hover:bg-white hover:shadow-md transition">
                <div class="w-14 h-14 bg-amber-600 text-white rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <div>
                    <span class="text-xs px-2.5 py-0.5 bg-amber-100 text-amber-800 rounded-full font-semibold inline-block mb-1">Kasi Kesejahteraan (Kesra)</span>
                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">Asnowo Hadi</h4>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2 hover:bg-white hover:shadow-md transition">
                <div class="w-14 h-14 bg-rose-600 text-white rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                </div>
                <div>
                    <span class="text-xs px-2.5 py-0.5 bg-rose-100 text-rose-800 rounded-full font-semibold inline-block mb-1">Kaur Keuangan</span>
                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">Irwanudin, S.E</h4>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2 hover:bg-white hover:shadow-md transition">
                <div class="w-14 h-14 bg-teal-600 text-white rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div>
                    <span class="text-xs px-2.5 py-0.5 bg-teal-100 text-teal-800 rounded-full font-semibold inline-block mb-1">Kaur Umum & Perencanaan</span>
                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">Hartanto</h4>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2 hover:bg-white hover:shadow-md transition">
                <div class="w-14 h-14 bg-slate-600 text-white rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                    <i class="fa-solid fa-map-pin"></i>
                </div>
                <div>
                    <span class="text-xs px-2.5 py-0.5 bg-slate-200 text-slate-700 rounded-full font-semibold inline-block mb-1">Kepala Dusun (I - VI)</span>
                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">Tafsirudin, Purnomo, dkk</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Batas Wilayah & Geografis -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm">
        <h2 class="text-2xl font-extrabold text-slate-900 mb-6">Letak Geografis & Batas Wilayah</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <span class="text-xs text-slate-500 font-semibold block">Sebelah Utara</span>
                <span class="font-bold text-slate-900 text-base mt-1 block">Kelurahan Untoro</span>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <span class="text-xs text-slate-500 font-semibold block">Sebelah Timur</span>
                <span class="font-bold text-slate-900 text-base mt-1 block">Kelurahan Purwodadi</span>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <span class="text-xs text-slate-500 font-semibold block">Sebelah Selatan</span>
                <span class="font-bold text-slate-900 text-base mt-1 block">Kelurahan Trimurjo</span>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <span class="text-xs text-slate-500 font-semibold block">Sebelah Barat</span>
                <span class="font-bold text-slate-900 text-base mt-1 block">Kelurahan Sukajadi</span>
            </div>
        </div>

        <div class="p-4 bg-slate-100 rounded-2xl text-xs text-slate-600">
            <i class="fa-solid fa-satellite mr-1.5 text-emerald-600"></i>
            Koordinat Geografis: <strong>5° 10' 12" LS</strong> dan <strong>105° 22' 54" BT</strong> dengan ketinggian ±80 mdpl (Dataran Rendah).
        </div>
    </section>
</div>
@endsection

