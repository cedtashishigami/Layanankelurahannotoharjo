@extends('layouts.admin')

@section('title', 'Detail & Validasi Surat - Kelurahan Notoharjo')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.surat.index') }}" class="p-2 text-slate-400 hover:text-slate-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pemeriksaan Berkas & Tindakan Surat</h1>
            <p class="text-xs text-slate-500 font-mono">Token: {{ $permohonan->token_qr }} • Tanggal: {{ $permohonan->tanggal_pengajuan->translatedFormat('d F Y') }}</p>
        </div>
    </div>

    <!-- Panel Status Saat Ini -->
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
                    Tahapan Saat Ini:
                </span>
                <h3 class="text-lg font-extrabold text-slate-900">
                    @if($permohonan->status === 'menunggu_verifikasi')
                        1. Menunggu Verifikasi Berkas oleh Kasi Pelayanan
                    @elseif($permohonan->status === 'diverifikasi_kasi')
                        2. Menunggu Pembukuan Nomor & Paraf Sekretaris
                    @elseif($permohonan->status === 'diparaf_sekretaris')
                        3. Menunggu Persetujuan & Tanda Tangan Lurah
                    @elseif($permohonan->status === 'selesai')
                        Selesai • Surat Telah Disahkan Resmi
                    @else
                        Permohonan Ditolak / Memerlukan Revisi
                    @endif
                </h3>
            </div>
        </div>

        @if($permohonan->status === 'selesai')
            <a href="{{ route('admin.surat.cetak', $permohonan->id_permohonan_surat) }}" target="_blank" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition shadow-sm flex items-center space-x-2 shrink-0">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Surat Resmi</span>
            </a>
        @endif
    </div>

    <!-- Data Pemohon & Berkas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Biodata Pemohon -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Data Pemohon (Warga)</h3>
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block">Nama Lengkap</span>
                    <strong class="text-slate-900 font-bold text-sm block mt-0.5">{{ $permohonan->penduduk->nama_lengkap }}</strong>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <span class="text-slate-400 block">NIK</span>
                        <strong class="text-slate-900 font-mono block">{{ $permohonan->penduduk->nik }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Nomor KK</span>
                        <strong class="text-slate-900 font-mono block">{{ $permohonan->penduduk->kartuKeluarga->nomor_kk ?? '-' }}</strong>
                    </div>
                </div>
                <div>
                    <span class="text-slate-400 block">Wilayah Domisili</span>
                    <span class="text-slate-800 font-medium block mt-0.5">
                        {{ $permohonan->penduduk->kartuKeluarga->rt->dusun->nama_dusun ?? 'Dusun' }} • RT {{ $permohonan->penduduk->kartuKeluarga->rt->nomor_rt ?? '-' }} / RW {{ $permohonan->penduduk->kartuKeluarga->rt->nomor_rw ?? '-' }}
                    </span>
                    <span class="text-slate-500 text-[11px] block">{{ $permohonan->penduduk->kartuKeluarga->alamat_lengkap ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Layanan Surat</span>
                    <strong class="text-emerald-700 font-bold block mt-0.5">{{ $permohonan->kodeSurat->nama_surat }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block">Keperluan Pemohon</span>
                    <p class="text-slate-800 bg-slate-50 p-2.5 rounded-xl border border-slate-100 mt-0.5 leading-relaxed">
                        {{ $permohonan->keperluan }}
                    </p>
                </div>
                @if($permohonan->keterangan_tambahan)
                    <div>
                        <span class="text-slate-400 block">Keterangan Tambahan</span>
                        <p class="text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-100 mt-0.5 leading-relaxed">
                            {{ $permohonan->keterangan_tambahan }}
                        </p>
                    </div>
                @endif
                @if($permohonan->nomor_surat)
                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400 block">Nomor Surat Terdaftar</span>
                        <strong class="text-emerald-700 font-mono text-sm block mt-0.5">{{ $permohonan->nomor_surat }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <!-- Berkas Lampiran yang Dicek Petugas -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4" x-data="{ previewModal: null }">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-sm">Berkas Persyaratan yang Diunggah</h3>
                <span class="text-[11px] text-slate-400 font-medium">{{ $permohonan->lampiranPermohonan->count() }} Dokumen Terlampir</span>
            </div>

            <div class="space-y-3">
                @forelse($permohonan->lampiranPermohonan as $lampiran)
                    @php
                        $ext = strtolower(pathinfo($lampiran->nama_file, PATHINFO_EXTENSION));
                        $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'heic']);
                        $fileUrl = route('lampiran.show', $lampiran->id_lampiran);
                    @endphp
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between text-xs gap-3">
                        <div class="flex items-center space-x-3 truncate">
                            @if($isImg)
                                <img src="{{ $fileUrl }}" alt="{{ $lampiran->nama_file }}" 
                                     @click="previewModal = '{{ $fileUrl }}'"
                                     class="w-12 h-12 object-cover rounded-xl border border-slate-200 cursor-zoom-in shrink-0 hover:scale-105 transition" title="Klik untuk memperbesar">
                            @else
                                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center font-bold text-base shrink-0 border border-rose-200">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>
                            @endif
                            <div class="truncate">
                                <strong class="text-slate-900 block truncate">{{ $lampiran->syaratSurat->nama_syarat ?? 'Berkas Persyaratan' }}</strong>
                                <span class="text-[11px] text-slate-400 block truncate font-mono">{{ $lampiran->nama_file }}</span>
                                <span class="text-[10px] uppercase font-bold text-slate-500 bg-slate-200 px-1.5 py-0.5 rounded mt-0.5 inline-block">{{ $ext }}</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-1.5 shrink-0">
                            @if($isImg)
                                <button type="button" @click="previewModal = '{{ $fileUrl }}'" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition flex items-center space-x-1">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                    <span>Lihat</span>
                                </button>
                            @endif
                            <a href="{{ $fileUrl }}" target="_blank" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition flex items-center space-x-1 shadow-sm">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                <span>Buka File</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-xs text-slate-400">
                        Pemohon tidak melampirkan berkas fisik.
                    </div>
                @endforelse
            </div>

            <!-- Modal Lightbox Preview Gambar -->
            <div x-show="previewModal" x-cloak class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4" @click.self="previewModal = null">
                <div class="bg-white rounded-3xl overflow-hidden max-w-3xl w-full max-h-[90vh] flex flex-col shadow-2xl">
                    <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <span class="font-bold text-slate-800 text-xs">Pratinjau Dokumen Berkas</span>
                        <button type="button" @click="previewModal = null" class="w-8 h-8 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-700 flex items-center justify-center transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="p-4 overflow-auto flex items-center justify-center bg-slate-900/5 min-h-[300px]">
                        <img :src="previewModal" class="max-h-[75vh] w-auto object-contain rounded-xl shadow">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Tindakan Aparat Berdasarkan Role & Tahapan -->
    @if($permohonan->status !== 'selesai' && $permohonan->status !== 'ditolak')
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6" x-data="{ action: '{{ $permohonan->status === "menunggu_verifikasi" ? "verifikasi_kasi" : ($permohonan->status === "diverifikasi_kasi" ? "paraf_sekretaris" : "setujui_lurah") }}' }">
            <div class="flex items-center space-x-2 pb-3 border-b border-slate-100">
                <i class="fa-solid fa-stamp text-emerald-600 text-lg"></i>
                <h3 class="font-bold text-slate-900 text-sm">Form Keputusan & Tindakan Petugas</h3>
            </div>

            <form action="{{ route('admin.surat.action', $permohonan->id_permohonan_surat) }}" method="POST" class="space-y-4">
                @csrf

                <!-- Pilih Tindakan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Keputusan</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-semibold">
                        @if($permohonan->status === 'menunggu_verifikasi')
                            <label class="p-3.5 rounded-xl border flex items-center space-x-2.5 cursor-pointer transition" :class="action === 'verifikasi_kasi' ? 'bg-emerald-50 border-emerald-500 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-600'">
                                <input type="radio" name="action" value="verifikasi_kasi" x-model="action">
                                <span>Verifikasi Berkas Sah (Kasi Pelayanan)</span>
                            </label>
                        @elseif($permohonan->status === 'diverifikasi_kasi')
                            <label class="p-3.5 rounded-xl border flex items-center space-x-2.5 cursor-pointer transition" :class="action === 'paraf_sekretaris' ? 'bg-sky-50 border-sky-500 text-sky-800' : 'bg-slate-50 border-slate-200 text-slate-600'">
                                <input type="radio" name="action" value="paraf_sekretaris" x-model="action">
                                <span>Paraf & Terbitkan Nomor Surat (Sekretaris)</span>
                            </label>
                        @elseif($permohonan->status === 'diparaf_sekretaris')
                            <label class="p-3.5 rounded-xl border flex items-center space-x-2.5 cursor-pointer transition" :class="action === 'setujui_lurah' ? 'bg-emerald-50 border-emerald-500 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-600'">
                                <input type="radio" name="action" value="setujui_lurah" x-model="action">
                                <span>Sahkan & Tanda Tangan Elektronik (Lurah)</span>
                            </label>
                        @endif

                        <label class="p-3.5 rounded-xl border flex items-center space-x-2.5 cursor-pointer transition" :class="action === 'tolak' ? 'bg-rose-50 border-rose-500 text-rose-800' : 'bg-slate-50 border-slate-200 text-slate-600'">
                            <input type="radio" name="action" value="tolak" x-model="action">
                            <span>Tolak Permohonan / Minta Revisi Berkas</span>
                        </label>
                    </div>
                </div>

                <!-- Input Nomor Surat (Khusus Sekretaris) -->
                <div x-show="action === 'paraf_sekretaris'">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nomor Registrasi Surat Resmi Kelurahan
                    </label>
                    <input type="text" name="nomor_surat" value="{{ $permohonan->nomor_surat ?? ($permohonan->kodeSurat->kode_klasifikasi . '/' . str_pad($permohonan->id_permohonan_surat, 3, '0', STR_PAD_LEFT) . '/NT/' . date('Y')) }}" placeholder="Contoh: 503/012/NT/2026" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-mono focus:ring-2 focus:ring-emerald-500">
                    <span class="text-[11px] text-slate-400 mt-1 block">Nomor ini otomatis dimasukkan ke dalam buku agenda surat keluar.</span>
                </div>

                <!-- Catatan / Keterangan Petugas -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Catatan Petugas (Wajib diisi jika menolak)
                    </label>
                    <textarea name="catatan" rows="3" placeholder="Tuliskan catatan verifikasi atau alasan perbaikan berkas pemohon..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm transition shadow-md flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-check-to-slot"></i>
                        <span>Simpan Keputusan & Teruskan Alur</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Log Riwayat Persetujuan -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Log Riwayat Alur Proses (Audit Trail)</h3>

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

