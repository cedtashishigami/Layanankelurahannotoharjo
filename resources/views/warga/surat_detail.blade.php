@extends('layouts.warga')

@section('title', 'Detail Permohonan Surat - Kelurahan Notoharjo')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center space-x-3">
        <a href="{{ route('warga.surat.index') }}" class="p-2 text-slate-400 hover:text-slate-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Detail Permohonan Surat</h1>
            <p class="text-xs text-slate-500 font-mono">Kode Token: {{ $permohonan->token_qr }}</p>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="p-6 rounded-3xl border flex flex-col sm:flex-row sm:items-center justify-between gap-4 {{ $permohonan->status === 'selesai' ? 'bg-emerald-50 border-emerald-200' : ($permohonan->status === 'ditolak' ? 'bg-rose-50 border-rose-200' : 'bg-amber-50 border-amber-200') }}">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 {{ $permohonan->status === 'selesai' ? 'bg-emerald-600 text-white' : ($permohonan->status === 'ditolak' ? 'bg-rose-600 text-white' : 'bg-amber-500 text-white') }}">
                @if($permohonan->status === 'selesai')
                    <i class="fa-solid fa-circle-check"></i>
                @elseif($permohonan->status === 'ditolak')
                    <i class="fa-solid fa-circle-xmark"></i>
                @else
                    <i class="fa-solid fa-hourglass-half"></i>
                @endif
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider block {{ $permohonan->status === 'selesai' ? 'text-emerald-800' : ($permohonan->status === 'ditolak' ? 'text-rose-800' : 'text-amber-800') }}">
                    Status Pengajuan:
                </span>
                <h3 class="text-lg font-extrabold text-slate-900">
                    @if($permohonan->status === 'menunggu_verifikasi')
                        Menunggu Pemeriksaan Berkas oleh Kasi Pelayanan
                    @elseif($permohonan->status === 'diverifikasi_kasi')
                        Berkas Disetujui Kasi • Menunggu Paraf & Nomor Surat Sekretaris
                    @elseif($permohonan->status === 'diparaf_sekretaris')
                        Nomor Surat Diterbitkan • Menunggu Tanda Tangan Lurah
                    @elseif($permohonan->status === 'selesai')
                        Surat Resmi Telah Diterbitkan & Sah
                    @else
                        Permohonan Memerlukan Perbaikan / Ditolak
                    @endif
                </h3>
            </div>
        </div>

        @if($permohonan->status === 'selesai')
            <a href="{{ route('admin.surat.cetak', $permohonan->id_permohonan_surat) }}" target="_blank" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition shadow-sm flex items-center space-x-2 shrink-0">
                <i class="fa-solid fa-print"></i>
                <span>Cetak / Unduh PDF</span>
            </a>
        @endif
    </div>

    <!-- Grid Data Surat & Lampiran -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Informasi Surat -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Informasi Permohonan</h3>
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block">Jenis Layanan</span>
                    <strong class="text-slate-900 font-bold text-sm block mt-0.5">{{ $permohonan->kodeSurat->nama_surat }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block">Subjek Pemohon</span>
                    <strong class="text-slate-900 font-bold block mt-0.5">{{ $permohonan->penduduk->nama_lengkap }}</strong>
                    <span class="text-slate-500 font-mono">NIK: {{ $permohonan->penduduk->nik }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Alamat Domisili</span>
                    <span class="text-slate-700 block mt-0.5">{{ $permohonan->penduduk->kartuKeluarga->alamat_lengkap ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Keperluan</span>
                    <p class="text-slate-800 font-medium bg-slate-50 p-2.5 rounded-xl border border-slate-100 mt-0.5 leading-relaxed">
                        {{ $permohonan->keperluan }}
                    </p>
                </div>
                @if($permohonan->nomor_surat)
                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400 block">Nomor Surat Resmi Kelurahan</span>
                        <strong class="text-emerald-700 font-mono text-sm block mt-0.5">{{ $permohonan->nomor_surat }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <!-- Berkas Lampiran -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4" x-data="{ previewModal: null }">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-sm">Berkas Persyaratan yang Diunggah</h3>
                <span class="text-[11px] text-slate-400 font-medium">{{ $permohonan->lampiranPermohonan->count() }} Berkas</span>
            </div>
            
            <div class="space-y-3">
                @forelse($permohonan->lampiranPermohonan as $lampiran)
                    @php
                        $ext = strtolower(pathinfo($lampiran->nama_file, PATHINFO_EXTENSION));
                        $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'heic']);
                        $fileUrl = route('lampiran.show', $lampiran->id_lampiran);
                    @endphp
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between text-xs gap-3">
                        <div class="flex items-center space-x-3 truncate">
                            @if($isImg)
                                <img src="{{ $fileUrl }}" alt="{{ $lampiran->nama_file }}" 
                                     @click="previewModal = '{{ $fileUrl }}'"
                                     class="w-10 h-10 object-cover rounded-lg border border-slate-200 cursor-zoom-in shrink-0">
                            @else
                                <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-lg flex items-center justify-center font-bold text-sm shrink-0 border border-rose-200">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>
                            @endif
                            <div class="truncate">
                                <strong class="text-slate-900 block truncate">{{ $lampiran->syaratSurat->nama_syarat ?? 'Berkas' }}</strong>
                                <span class="text-[11px] text-slate-400 block truncate">{{ $lampiran->nama_file }}</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-1.5 shrink-0">
                            @if($isImg)
                                <button type="button" @click="previewModal = '{{ $fileUrl }}'" class="px-2.5 py-1.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 rounded-lg font-bold text-xs transition">
                                    Lihat
                                </button>
                            @endif
                            <a href="{{ $fileUrl }}" target="_blank" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs transition shadow-sm">
                                Buka
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 py-4 text-center">
                        Tidak ada berkas yang dilampirkan.
                    </div>
                @endforelse
            </div>

            <!-- Modal Lightbox Preview Gambar -->
            <div x-show="previewModal" x-cloak class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4" @click.self="previewModal = null">
                <div class="bg-white rounded-3xl overflow-hidden max-w-2xl w-full max-h-[90vh] flex flex-col shadow-2xl">
                    <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <span class="font-bold text-slate-800 text-xs">Pratinjau Dokumen Berkas</span>
                        <button type="button" @click="previewModal = null" class="w-8 h-8 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-700 flex items-center justify-center transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="p-4 overflow-auto flex items-center justify-center bg-slate-900/5 min-h-[250px]">
                        <img :src="previewModal" class="max-h-[70vh] w-auto object-contain rounded-xl shadow">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Alur Verifikasi (Multi-Level Approval) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Riwayat & Catatan Alur Verifikasi</h3>

        <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
            @foreach($permohonan->riwayatStatus as $riwayat)
                <div class="relative">
                    <div class="absolute -left-6 top-1.5 w-4 h-4 rounded-full bg-emerald-600 border-2 border-white shadow"></div>
                    <div class="text-xs text-slate-400">{{ $riwayat->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
                    <h4 class="text-sm font-bold text-slate-900">{{ $riwayat->tahapan }}</h4>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $riwayat->catatan_petugas }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

