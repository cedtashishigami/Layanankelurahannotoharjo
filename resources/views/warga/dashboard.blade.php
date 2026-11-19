@extends('layouts.warga')

@section('title', 'Dashboard Warga - Kelurahan Notoharjo')

@section('content')
<div class="space-y-8">
    <!-- Header Selamat Datang -->
    <div class="bg-gradient-to-r from-emerald-800 to-slate-900 text-white rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 shadow-sm">
        <div class="space-y-2">
            <span class="text-xs font-semibold px-3 py-1 bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 rounded-full inline-block">
                Akun Warga Terverifikasi
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ $user->name }}</h1>
            <p class="text-slate-300 text-xs sm:text-sm">
                Kelurahan Notoharjo • {{ $penduduk?->kartuKeluarga?->rt?->dusun?->nama_dusun ?? 'Dusun Kelurahan' }}
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('warga.surat.create') }}" class="px-5 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold rounded-xl text-xs sm:text-sm transition flex items-center space-x-2 shadow-md">
                <i class="fa-solid fa-file-circle-plus"></i>
                <span>Buat Pengajuan Surat</span>
            </a>
        </div>
    </div>

    <!-- Grid Data Identitas & Anggota Keluarga -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Biodata Warga & KK -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Data Kependudukan</h3>
                    <span class="text-xs text-slate-500">Arsip Resmi Kelurahan Notoharjo</span>
                </div>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block">Nomor Induk Kependudukan (NIK)</span>
                    <strong class="text-slate-900 font-mono text-sm block mt-0.5">{{ $penduduk?->nik ?? $user->nik }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block">Nomor Kartu Keluarga (KK)</span>
                    <strong class="text-slate-900 font-mono text-sm block mt-0.5">{{ $penduduk?->kartuKeluarga?->nomor_kk ?? '-' }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block">Alamat Domisili</span>
                    <span class="text-slate-800 font-medium block mt-0.5">{{ $penduduk?->kartuKeluarga?->alamat_lengkap ?? '-' }}</span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100">
                    <div>
                        <span class="text-slate-400 block">Pekerjaan</span>
                        <span class="text-slate-800 font-semibold block">{{ $penduduk?->pekerjaan?->nama_pekerjaan ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Pendidikan</span>
                        <span class="text-slate-800 font-semibold block">{{ $penduduk?->pendidikan?->nama_pendidikan ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Anggota Keluarga Dalam KK -->
            @if($anggotaKeluarga->count() > 1)
                <div class="pt-4 border-t border-slate-100">
                    <span class="text-xs font-bold text-slate-800 block mb-3">Anggota Keluarga Dalam KK ({{ $anggotaKeluarga->count() }} Jiwa):</span>
                    <div class="space-y-2">
                        @foreach($anggotaKeluarga as $ang)
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                                <div>
                                    <strong class="text-slate-900 block">{{ $ang->nama_lengkap }}</strong>
                                    <span class="text-[11px] text-slate-400">NIK: {{ $ang->nik }}</span>
                                </div>
                                <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-[10px] font-semibold rounded">
                                    {{ $ang->status_hubungan_keluarga }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Surat Terakhir & Notifikasi -->
        <div class="lg:col-span-7 space-y-8">
            <!-- Permohonan Surat Terakhir -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Permohonan Surat Terakhir</h3>
                    <a href="{{ route('warga.surat.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($suratTerakhir as $st)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-emerald-50/40 transition">
                            <div>
                                <span class="text-[11px] text-slate-400 block">{{ $st->tanggal_pengajuan->translatedFormat('d M Y') }} • Token: {{ $st->token_qr }}</span>
                                <strong class="text-sm text-slate-900 block mt-0.5">{{ $st->kodeSurat->nama_surat }}</strong>
                                <span class="text-xs text-slate-500">Pemohon: {{ $st->penduduk->nama_lengkap }}</span>
                            </div>

                            <div class="flex items-center space-x-3">
                                @if($st->status === 'menunggu_verifikasi')
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Verifikasi Kasi</span>
                                @elseif($st->status === 'diverifikasi_kasi')
                                    <span class="px-3 py-1 bg-sky-100 text-sky-800 text-xs font-bold rounded-full">Paraf Sekdes</span>
                                @elseif($st->status === 'diparaf_sekretaris')
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-bold rounded-full">Tanda Tangan Lurah</span>
                                @elseif($st->status === 'selesai')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Selesai / Terbit</span>
                                @else
                                    <span class="px-3 py-1 bg-rose-100 text-rose-800 text-xs font-bold rounded-full">Ditolak</span>
                                @endif

                                <a href="{{ route('warga.surat.detail', $st->id_permohonan_surat) }}" class="p-2 text-slate-400 hover:text-emerald-600">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-slate-400">
                            Anda belum pernah mengajukan surat online.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Notifikasi & Pemberitahuan (Solusi Bab 5 Hal 109) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center space-x-2 pb-3 border-b border-slate-100">
                    <i class="fa-solid fa-bell text-emerald-600"></i>
                    <h3 class="font-bold text-slate-900 text-sm">Pemberitahuan & Notifikasi</h3>
                </div>

                <div class="space-y-3">
                    @forelse($notifikasi as $notif)
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start space-x-3 text-xs">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></div>
                            <div class="flex-grow">
                                <strong class="text-slate-900 block font-semibold">{{ $notif->judul }}</strong>
                                <p class="text-slate-600 mt-0.5 leading-relaxed">{{ $notif->pesan }}</p>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-xs text-slate-400">
                            Tidak ada notifikasi baru saat ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

