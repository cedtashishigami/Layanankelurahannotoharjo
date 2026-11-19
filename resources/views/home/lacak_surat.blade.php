@extends('layouts.app')

@section('title', 'Lacak Permohonan Surat - Kelurahan Notoharjo')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
        <h1 class="text-3xl font-extrabold tracking-tight">Pelacakan Status Surat Mandiri</h1>
        <p class="text-emerald-200 text-sm">Pantau tahapan verifikasi dan pengesahan surat administrasi Anda secara real-time</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!-- Form Pencarian -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <form action="{{ route('lacak.surat') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-qrcode text-lg"></i>
                </span>
                <input type="text" name="q" value="{{ $query }}" required placeholder="Ketik NIK KTP atau Kode Token Surat (contoh: 1802011508850002)" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
            </div>
            <button type="submit" class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition shadow-sm flex items-center justify-center space-x-2 shrink-0">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Lacak Berkas</span>
            </button>
        </form>
    </div>

    @if($query)
        @if($hasil)
            <!-- Detail Hasil Pelacakan -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">HASIL PELACAKAN</span>
                        <h2 class="text-xl font-extrabold text-slate-900">{{ $hasil->kodeSurat->nama_surat }}</h2>
                        <span class="text-xs text-slate-500">Nomor Registrasi / Token: <strong class="text-slate-800 font-mono">{{ $hasil->token_qr }}</strong></span>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        @if($hasil->status === 'menunggu_verifikasi')
                            <span class="px-4 py-2 bg-amber-100 text-amber-800 rounded-full font-bold text-xs inline-flex items-center">
                                <i class="fa-solid fa-clock mr-1.5"></i> Menunggu Verifikasi Kasi
                            </span>
                        @elseif($hasil->status === 'diverifikasi_kasi')
                            <span class="px-4 py-2 bg-sky-100 text-sky-800 rounded-full font-bold text-xs inline-flex items-center">
                                <i class="fa-solid fa-file-signature mr-1.5"></i> Menunggu Paraf Sekretaris
                            </span>
                        @elseif($hasil->status === 'diparaf_sekretaris')
                            <span class="px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full font-bold text-xs inline-flex items-center">
                                <i class="fa-solid fa-stamp mr-1.5"></i> Menunggu Persetujuan Lurah
                            </span>
                        @elseif($hasil->status === 'selesai')
                            <span class="px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full font-bold text-xs inline-flex items-center">
                                <i class="fa-solid fa-circle-check mr-1.5"></i> Selesai & Terverifikasi
                            </span>
                        @else
                            <span class="px-4 py-2 bg-rose-100 text-rose-800 rounded-full font-bold text-xs inline-flex items-center">
                                <i class="fa-solid fa-circle-xmark mr-1.5"></i> Ditolak / Perlu Revisi
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Data Pemohon -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <div>
                        <span class="text-slate-400 block text-xs">Nama Pemohon (Subjek Surat)</span>
                        <strong class="text-slate-900 font-bold text-base block mt-0.5">{{ $hasil->penduduk->nama_lengkap }}</strong>
                        <span class="text-slate-500 text-xs">NIK: {{ $hasil->penduduk->nik }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-xs">Keperluan Permohonan</span>
                        <span class="text-slate-800 font-medium block mt-0.5">{{ $hasil->keperluan }}</span>
                        <span class="text-slate-500 text-xs">Tanggal Pengajuan: {{ $hasil->tanggal_pengajuan->translatedFormat('d F Y') }}</span>
                    </div>
                    @if($hasil->nomor_surat)
                        <div class="sm:col-span-2 pt-2 border-t border-slate-200">
                            <span class="text-slate-400 block text-xs">Nomor Surat Resmi Kelurahan</span>
                            <strong class="text-emerald-700 font-mono text-sm block mt-0.5">{{ $hasil->nomor_surat }}</strong>
                        </div>
                    @endif
                </div>

                <!-- Timeline Audit Trail -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Histori Alur Proses Surat</h3>
                    <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                        @foreach($hasil->riwayatStatus as $riwayat)
                            <div class="relative">
                                <div class="absolute -left-6 top-1.5 w-4 h-4 rounded-full bg-emerald-600 border-2 border-white shadow"></div>
                                <div class="text-xs text-slate-400">{{ $riwayat->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
                                <h4 class="text-sm font-bold text-slate-800">{{ $riwayat->tahapan }}</h4>
                                <p class="text-xs text-slate-600 mt-1">{{ $riwayat->catatan_petugas }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($hasil->status === 'selesai')
                    <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-3xl"></i>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Surat Telah Sah & Selesai</h4>
                                <p class="text-xs text-slate-600">Dokumen telah disahkan secara digital oleh Lurah Notoharjo.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.surat.cetak', $hasil->id_permohonan_surat) }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition shadow-sm flex items-center space-x-1.5 shrink-0">
                            <i class="fa-solid fa-print"></i>
                            <span>Cetak / Unduh PDF</span>
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm space-y-3">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-2xl mx-auto">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Data Tidak Ditemukan</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                    Tidak ditemukan permohonan surat dengan kata kunci "<strong>{{ $query }}</strong>". Pastikan NIK atau Token yang Anda masukkan benar.
                </p>
            </div>
        @endif
    @endif
</div>
@endsection

