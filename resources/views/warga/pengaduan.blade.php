@extends('layouts.warga')

@section('title', 'Aspirasi & Pengaduan Saya - Kelurahan Notoharjo')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kanal Aspirasi & Pengaduan Warga</h1>
        <p class="text-xs text-slate-500">Sampaikan keluhan atau aspirasi terkait lingkungan tempat tinggal Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Kirim Aduan -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Buat Pengaduan Baru</h3>

            <form action="{{ route('warga.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Wilayah Dusun</label>
                    <select name="id_dusun" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="">-- Pilih Dusun Terkait --</option>
                        @foreach($dusunList as $d)
                            <option value="{{ $d->id_dusun }}">{{ $d->nama_dusun }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori</label>
                    <select name="kategori" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="Infrastruktur & Jalan">Infrastruktur & Jalan</option>
                        <option value="Pertanian & Pengairan">Pertanian & Pengairan / Irigasi</option>
                        <option value="Bantuan Sosial">Bantuan Sosial & Kesejahteraan</option>
                        <option value="Pelayanan Kelurahan">Pelayanan Kantor Kelurahan</option>
                        <option value="Keamanan & Ketertiban">Keamanan & Ketertiban</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Laporan</label>
                    <input type="text" name="judul_laporan" required placeholder="Contoh: Lampu jalan mati di Dusun 1" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Isi Laporan Lengkap</label>
                    <textarea name="isi_laporan" rows="4" required placeholder="Jelaskan kronologi dan lokasi secara jelas..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lampiran Foto Bukti</label>
                    <input type="file" name="foto_bukti" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs sm:text-sm transition shadow-sm">
                    Kirim Laporan
                </button>
            </form>
        </div>

        <!-- Daftar Pengaduan Saya -->
        <div class="lg:col-span-7 space-y-4">
            <h3 class="font-bold text-slate-900 text-sm">Riwayat Laporan Saya</h3>

            @forelse($pengaduan as $aduan)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold rounded-full">
                            {{ $aduan->kategori }}
                        </span>
                        <span class="text-slate-400">{{ $aduan->created_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>

                    <h4 class="font-bold text-slate-900 text-base">{{ $aduan->judul_laporan }}</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $aduan->isi_laporan }}</p>

                    @if($aduan->tanggapan_petugas)
                        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 text-xs space-y-1 mt-2">
                            <span class="font-bold text-emerald-800 block">Tanggapan Kelurahan:</span>
                            <p class="text-emerald-950 leading-relaxed">{{ $aduan->tanggapan_petugas }}</p>
                        </div>
                    @else
                        <div class="text-xs text-amber-600 flex items-center space-x-1 pt-1">
                            <i class="fa-solid fa-clock"></i>
                            <span>Menunggu pemeriksaan aparat desa</span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 text-xs text-slate-400">
                    Anda belum memiliki riwayat pengaduan.
                </div>
            @endforelse

            <div>
                {{ $pengaduan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

