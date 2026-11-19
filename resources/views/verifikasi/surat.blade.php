<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keaslian Surat - Kelurahan Notoharjo</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-lampung-tengah.png') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 min-h-screen py-10 px-4 flex items-center justify-center">

    <div class="max-w-xl w-full bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-xl space-y-6">
        <!-- Logo Kelurahan -->
        <div class="text-center space-y-2">
            <img src="{{ asset('logo-lampung-tengah.png') }}" alt="Logo Kabupaten Lampung Tengah" class="w-16 h-16 object-contain mx-auto drop-shadow-md">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Pemerintah Kelurahan Notoharjo</h2>
            <p class="text-xs text-slate-500">Kecamatan Trimurjo, Kabupaten Lampung Tengah, Provinsi Lampung</p>
        </div>

        @if($surat && $surat->status === 'selesai')
            <!-- Valid Banner -->
            <div class="p-5 bg-emerald-50 rounded-2xl border border-emerald-200 text-center space-y-2">
                <div class="w-12 h-12 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h3 class="text-lg font-extrabold text-emerald-950">DOKUMEN ASLI & TERVERIFIKASI</h3>
                <p class="text-xs text-emerald-800 leading-relaxed">
                    Surat ini sah dan terdaftar resmi di basis data pelayanan administrasi Kelurahan Notoharjo.
                </p>
            </div>

            <!-- Detail Data Dokumen -->
            <div class="space-y-3 text-xs sm:text-sm bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500">Nomor Registrasi Surat</span>
                    <strong class="text-slate-900 font-mono">{{ $surat->nomor_surat }}</strong>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500">Jenis Dokumen</span>
                    <strong class="text-slate-900">{{ $surat->kodeSurat->nama_surat }}</strong>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500">Nama Pemohon (Warga)</span>
                    <strong class="text-slate-900 uppercase">{{ $surat->penduduk->nama_lengkap }}</strong>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500">NIK (KTP)</span>
                    <span class="font-mono text-slate-800 font-semibold">{{ substr($surat->penduduk->nik, 0, 6) }}******{{ substr($surat->penduduk->nik, -4) }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500">Keperluan</span>
                    <span class="text-slate-800 font-medium text-right max-w-[250px]">{{ $surat->keperluan }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500">Tanggal Pengesahan</span>
                    <span class="text-slate-800 font-semibold">{{ $surat->tanggal_disahkan ? $surat->tanggal_disahkan->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <div class="flex justify-between pt-1">
                    <span class="text-slate-500">Pengesah Resmi</span>
                    <strong class="text-emerald-700">Kepala Kelurahan Notoharjo</strong>
                </div>
            </div>

            <div class="text-center pt-2">
                <a href="{{ route('admin.surat.cetak', $surat->id_permohonan_surat) }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition inline-flex items-center space-x-1.5 shadow-sm">
                    <i class="fa-solid fa-print"></i>
                    <span>Tampilkan Dokumen Surat</span>
                </a>
            </div>
        @else
            <!-- Invalid / Not Found Banner -->
            <div class="p-6 bg-rose-50 rounded-2xl border border-rose-200 text-center space-y-3">
                <div class="w-12 h-12 bg-rose-600 text-white rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <h3 class="text-base font-extrabold text-rose-950">DOKUMEN TIDAK TERDAFTAR / BELUM SAH</h3>
                <p class="text-xs text-rose-800 leading-relaxed">
                    Kode verifikasi "<strong>{{ $token }}</strong>" tidak ditemukan atau permohonan surat belum disetujui secara resmi oleh Lurah Notoharjo.
                </p>
            </div>
        @endif

        <div class="text-center pt-4 border-t border-slate-100">
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600 transition">
                &larr; Kembali ke Beranda Kelurahan Notoharjo
            </a>
        </div>
    </div>

</body>
</html>

