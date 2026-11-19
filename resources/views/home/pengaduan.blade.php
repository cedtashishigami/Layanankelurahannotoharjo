@extends('layouts.app')

@section('title', 'Kanal Aspirasi & Pengaduan Warga - Notoharjo')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight">Kanal Aspirasi & Pengaduan Masyarakat</h1>
        <p class="text-emerald-200 mt-2 text-sm">Sampaikan keluhan infrastruktur jalan, persawahan pertanian, pelayanan kelurahan, dan bantuan sosial secara transparan</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Form Kirim Aduan (Wajib Login atau Direct) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Sampaikan Aspirasi Baru</h3>
                <p class="text-xs text-slate-500 mb-6">Aspirasi Anda akan langsung ditindaklanjuti oleh aparat kelurahan terkait.</p>

                @auth
                    <form action="{{ route('warga.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Wilayah Kejadian / Dusun</label>
                            <select name="id_dusun" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                                <option value="">-- Pilih Dusun Terkait --</option>
                                @foreach($dusunList as $d)
                                    <option value="{{ $d->id_dusun }}">{{ $d->nama_dusun }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Pengaduan</label>
                            <select name="kategori" required class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                                <option value="Infrastruktur & Jalan">Infrastruktur & Jalan</option>
                                <option value="Pertanian & Pengairan">Pertanian & Pengairan / Irigasi</option>
                                <option value="Bantuan Sosial">Bantuan Sosial & Kesejahteraan</option>
                                <option value="Pelayanan Kelurahan">Pelayanan Kantor Kelurahan</option>
                                <option value="Keamanan & Ketertiban">Keamanan & Ketertiban Lingkungan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Laporan</label>
                            <input type="text" name="judul_laporan" required placeholder="Contoh: Perbaikan gorong-gorong irigasi Dusun 2" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Uraian / Isi Laporan</label>
                            <textarea name="isi_laporan" rows="4" required placeholder="Jelaskan secara rinci kendala atau aspirasi Anda..." class="w-full py-2.5 px-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Lampiran Foto Bukti (Opsional)</label>
                            <input type="file" name="foto_bukti" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        </div>

                        <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition shadow-sm">
                            Kirim Aspirasi Sekarang
                        </button>
                    </form>
                @else
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 text-center space-y-4">
                        <i class="fa-solid fa-lock text-slate-400 text-3xl"></i>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Untuk menjaga validitas laporan dan menghindari data palsu, warga diharapkan masuk dengan akun terdaftar untuk mengirim pengaduan.
                        </p>
                        <div class="flex gap-2 justify-center">
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition">
                                Masuk Akun
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold rounded-xl text-xs transition">
                                Daftar Warga
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Daftar Aspirasi Publik & Respon Aparat -->
        <div class="lg:col-span-7 space-y-6">
            <h3 class="text-xl font-bold text-slate-900">Aspirasi Terkini Masyarakat</h3>

            @forelse($pengaduanPublik as $aduan)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2 text-xs">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold rounded-full">
                                {{ $aduan->kategori }}
                            </span>
                            @if($aduan->dusun)
                                <span class="text-slate-400">• {{ $aduan->dusun->nama_dusun }}</span>
                            @endif
                        </div>
                        <span class="text-xs text-slate-400">{{ $aduan->created_at->diffForHumans() }}</span>
                    </div>

                    <h4 class="text-base font-bold text-slate-900">{{ $aduan->judul_laporan }}</h4>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $aduan->isi_laporan }}</p>

                    <!-- Tanggapan Aparat -->
                    @if($aduan->tanggapan_petugas)
                        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 space-y-1">
                            <div class="flex items-center space-x-1.5 text-xs font-bold text-emerald-800">
                                <i class="fa-solid fa-reply"></i>
                                <span>Tanggapan Resmi Kelurahan:</span>
                            </div>
                            <p class="text-xs text-emerald-900 leading-relaxed">{{ $aduan->tanggapan_petugas }}</p>
                        </div>
                    @else
                        <div class="text-xs text-amber-600 flex items-center space-x-1">
                            <i class="fa-solid fa-clock"></i>
                            <span>Menunggu tanggapan dari aparat kelurahan</span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 text-slate-500 text-sm">
                    Belum ada aspirasi publik yang masuk.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

