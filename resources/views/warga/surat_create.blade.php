@extends('layouts.warga')

@section('title', 'Ajukan Surat Mandiri - Kelurahan Notoharjo')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('warga.dashboard') }}" class="p-2 text-slate-400 hover:text-slate-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Permohonan Surat Administrasi</h1>
            <p class="text-xs text-slate-500">Isi formulir pengajuan dan unggah dokumen persyaratan yang diminta</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm" x-data="{
        selectedId: '{{ $selectedKodeSurat?->id_kode_surat ?? ($jenisSurat->first()->id_kode_surat ?? '') }}',
        syaratMap: {
            @foreach($jenisSurat as $js)
                '{{ $js->id_kode_surat }}': [
                    @foreach($js->syaratSurat as $sy)
                        { id: '{{ $sy->id_syarat_surat }}', nama: '{{ $sy->nama_syarat }}', wajib: {{ $sy->is_wajib ? 'true' : 'false' }}, ket: '{{ $sy->keterangan }}' },
                    @endforeach
                ],
            @endforeach
        }
    }">
        <form action="{{ route('warga.surat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. Pilih Jenis Surat -->
            <div>
                <label for="id_kode_surat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    1. Pilih Jenis Layanan Surat
                </label>
                <select name="id_kode_surat" id="id_kode_surat" x-model="selectedId" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white font-medium">
                    @foreach($jenisSurat as $surat)
                        <option value="{{ $surat->id_kode_surat }}">{{ $surat->nama_surat }} (Kode {{ $surat->kode_klasifikasi }})</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Subjek Surat (Diri Sendiri atau Anggota Keluarga dalam KK) -->
            <div>
                <label for="id_penduduk" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    2. Pemohon / Subjek Surat
                </label>
                <select name="id_penduduk" id="id_penduduk" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white font-medium">
                    @foreach($anggotaKeluarga as $anggota)
                        <option value="{{ $anggota->id_penduduk }}">
                            {{ $anggota->nama_lengkap }} (NIK: {{ $anggota->nik }} - {{ $anggota->status_hubungan_keluarga }})
                        </option>
                    @endforeach
                </select>
                <span class="text-[11px] text-slate-400 mt-1 block">Anda dapat mengajukan permohonan atas nama diri sendiri atau anggota keluarga yang terdaftar dalam KK Anda.</span>
            </div>

            <!-- 3. Keperluan Pengajuan -->
            <div>
                <label for="keperluan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    3. Keperluan Surat
                </label>
                <textarea name="keperluan" id="keperluan" rows="3" required placeholder="Contoh: Pengajuan pinjaman modal usaha KUR Bank BRI / Persyaratan melamar pekerjaan / Pendaftaran sekolah" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white"></textarea>
            </div>

            <!-- 4. Keterangan Tambahan -->
            <div>
                <label for="keterangan_tambahan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    4. Keterangan Tambahan (Opsional)
                </label>
                <input type="text" name="keterangan_tambahan" id="keterangan_tambahan" placeholder="Contoh: Nama Usaha: Toko Kelontong Berkah Welit, berdiri sejak 2021" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white">
            </div>

            <!-- 5. Berkas Lampiran Persyaratan -->
            <div class="pt-4 border-t border-slate-200">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        5. Unggah Berkas Persyaratan
                    </label>
                    <span class="text-[11px] text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg font-semibold">
                        <i class="fa-solid fa-shield-halved mr-1"></i>Dokumen Terenkripsi Aman
                    </span>
                </div>
                <p class="text-xs text-slate-500 mb-4">Format yang didukung: JPG, PNG, atau PDF (Ukuran maksimal 3MB per berkas). Foto dokumen asli menggunakan kamera ponsel Anda dengan pencahayaan jelas.</p>

                <div class="space-y-4">
                    <template x-for="item in (syaratMap[selectedId] || [])" :key="item.id">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200" x-data="{ fileName: '', fileSize: '', isImage: false, previewUrl: '' }">
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-bold text-slate-800" x-text="item.nama"></span>
                                <span class="text-[10px] px-2 py-0.5 rounded font-semibold" :class="item.wajib ? 'bg-rose-100 text-rose-700' : 'bg-slate-200 text-slate-600'" x-text="item.wajib ? 'Wajib Diunggah' : 'Opsional'"></span>
                            </div>
                            <span class="text-[11px] text-slate-400 block mb-2.5" x-text="item.ket"></span>
                            
                            <div class="relative">
                                <input type="file" :name="'lampiran[' + item.id + ']'" accept="image/*,.pdf" 
                                    :required="item.wajib"
                                    @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            fileName = file.name;
                                            fileSize = (file.size / 1024).toFixed(1) + ' KB';
                                            isImage = file.type.startsWith('image/');
                                            if (isImage) {
                                                const reader = new FileReader();
                                                reader.onload = (e) => previewUrl = e.target.result;
                                                reader.readAsDataURL(file);
                                            } else {
                                                previewUrl = '';
                                            }
                                        } else {
                                            fileName = '';
                                            fileSize = '';
                                            previewUrl = '';
                                        }
                                    "
                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 cursor-pointer">
                            </div>

                            <!-- Live Feedback & Preview Box -->
                            <div x-show="fileName" class="mt-3 p-3 bg-white rounded-xl border border-emerald-200 flex items-center justify-between text-xs" style="display: none;">
                                <div class="flex items-center space-x-3 truncate">
                                    <template x-if="isImage && previewUrl">
                                        <img :src="previewUrl" class="w-10 h-10 object-cover rounded-lg border border-slate-200 shrink-0">
                                    </template>
                                    <template x-if="!isImage">
                                        <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-lg flex items-center justify-center font-bold text-xs shrink-0">
                                            <i class="fa-solid fa-file-pdf text-base"></i>
                                        </div>
                                    </template>
                                    <div class="truncate">
                                        <span class="font-bold text-slate-800 block truncate max-w-[220px]" x-text="fileName"></span>
                                        <span class="text-[10px] text-slate-400" x-text="fileSize"></span>
                                    </div>
                                </div>
                                <span class="text-[11px] text-emerald-600 font-bold flex items-center space-x-1 shrink-0">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Siap Dikirim</span>
                                </span>
                            </div>
                        </div>
                    </template>

                    <!-- Notice if no requirement needed -->
                    <div x-show="!(syaratMap[selectedId] && syaratMap[selectedId].length)" class="p-6 bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-center text-xs text-slate-400" style="display: none;">
                        <i class="fa-solid fa-circle-info text-slate-300 text-xl mb-1.5 block"></i>
                        <span>Layanan surat ini tidak memerlukan unggahan berkas khusus. Petugas akan memvalidasi data berdasarkan arsip kependudukan Anda.</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition shadow-md shadow-emerald-200 flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Permohonan Surat</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

