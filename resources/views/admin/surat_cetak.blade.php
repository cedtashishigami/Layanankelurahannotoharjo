<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $permohonan->kodeSurat->nama_surat }} - {{ $permohonan->penduduk->nama_lengkap }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-lampung-tengah.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tinos:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tinos', serif;
            color: #000;
            background-color: #f1f5f9;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 25mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        @media print {
            body {
                background: white !important;
                margin: 0 !important;
            }
            .page {
                box-shadow: none !important;
                margin: 0 !important;
                width: 100% !important;
                padding: 10mm 15mm !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Print Control Bar (Hidden on Print) -->
    <div class="no-print sticky top-0 z-50 bg-slate-900 text-white p-4 shadow-lg mb-6 flex justify-between items-center max-w-4xl mx-auto rounded-b-2xl">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.surat.detail', $permohonan->id_permohonan_surat) }}" class="text-xs text-slate-300 hover:text-white flex items-center space-x-1">
                <span>&larr; Kembali</span>
            </a>
            <span class="text-xs font-mono bg-slate-800 px-2.5 py-1 rounded">Token: {{ $permohonan->token_qr }}</span>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="window.print()" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs transition shadow flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Dokumen Resmi</span>
            </button>
        </div>
    </div>

    <!-- Official Letter Page -->
    <div class="page">
        <!-- KOP SURAT RESMI -->
        <div class="relative pb-3 border-b-[3px] border-black flex items-center">
            <!-- Lambang Resmi Kabupaten Lampung Tengah -->
            <img src="{{ asset('logo-lampung-tengah.png') }}" alt="Lambang Daerah Kabupaten Lampung Tengah" class="w-20 h-24 object-contain absolute left-1 top-0">

            <div class="w-full text-center pl-20 pr-4">
                <h3 class="text-base font-bold tracking-widest uppercase m-0 leading-tight">
                    PEMERINTAH KABUPATEN LAMPUNG TENGAH
                </h3>
                <h2 class="text-lg font-bold tracking-wider uppercase m-0 leading-tight">
                    KECAMATAN TRIMURJO
                </h2>
                <h1 class="text-2xl font-black tracking-widest uppercase m-0 leading-tight mt-1">
                    KELURAHAN NOTOHARJO
                </h1>
                <p class="text-xs text-slate-700 m-0 mt-1 italic font-sans">
                    Alamat: Jl. Veteran No. 12, Bedeng 17 Polos, Kelurahan Notoharjo, Kec. Trimurjo 34172
                </p>
            </div>

            <!-- Garis ganda tipis di bawah -->
            <div class="absolute -bottom-1 left-0 right-0 border-b border-black"></div>
        </div>

        <!-- JUDUL & NOMOR SURAT -->
        <div class="text-center mt-6 mb-6">
            <h2 class="text-lg font-bold uppercase underline tracking-wider m-0">
                {{ $permohonan->kodeSurat->nama_surat }}
            </h2>
            <p class="text-sm font-bold font-mono mt-0.5 m-0">
                Nomor : {{ $permohonan->nomor_surat ?? ($permohonan->kodeSurat->kode_klasifikasi . '/' . str_pad($permohonan->id_permohonan_surat, 3, '0', STR_PAD_LEFT) . '/NT/' . date('Y')) }}
            </p>
        </div>

        <!-- ISI KETERANGAN SURAT -->
        <div class="text-sm leading-relaxed text-justify space-y-4">
            <p>
                Yang bertanda tangan di bawah ini, Kepala Kelurahan Notoharjo, Kecamatan Trimurjo, Kabupaten Lampung Tengah, dengan ini menerangkan dengan sebenarnya bahwa:
            </p>

            <!-- Tabel Biodata Warga -->
            <table class="w-full my-3 text-sm">
                <tbody>
                    <tr>
                        <td class="w-48 py-1 font-semibold">Nama Lengkap</td>
                        <td class="w-4 py-1">:</td>
                        <td class="py-1 font-bold uppercase">{{ $permohonan->penduduk->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-semibold">NIK (No. KTP)</td>
                        <td class="py-1">:</td>
                        <td class="py-1 font-mono font-bold">{{ $permohonan->penduduk->nik }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-semibold">Nomor Kartu Keluarga</td>
                        <td class="py-1">:</td>
                        <td class="py-1 font-mono">{{ $permohonan->penduduk->kartuKeluarga->nomor_kk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-semibold">Tempat, Tanggal Lahir</td>
                        <td class="py-1">:</td>
                        <td class="py-1">{{ $permohonan->penduduk->tempat_lahir }}, {{ $permohonan->penduduk->tanggal_lahir->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-semibold">Jenis Kelamin</td>
                        <td class="py-1">:</td>
                        <td class="py-1">{{ $permohonan->penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-semibold">Agama</td>
                        <td class="py-1">:</td>
                        <td class="py-1">{{ $permohonan->penduduk->agama }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-semibold">Pekerjaan</td>
                        <td class="py-1">:</td>
                        <td class="py-1">{{ $permohonan->penduduk->pekerjaan->nama_pekerjaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-semibold">Status Perkawinan</td>
                        <td class="py-1">:</td>
                        <td class="py-1">{{ $permohonan->penduduk->status_kawin }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-semibold align-top">Alamat Domisili</td>
                        <td class="py-1 align-top">:</td>
                        <td class="py-1">
                            {{ $permohonan->penduduk->kartuKeluarga->alamat_lengkap ?? 'Kelurahan Notoharjo' }}, 
                            RT {{ $permohonan->penduduk->kartuKeluarga->rt->nomor_rt ?? '001' }} / RW {{ $permohonan->penduduk->kartuKeluarga->rt->nomor_rw ?? '001' }}, 
                            {{ $permohonan->penduduk->kartuKeluarga->rt->dusun->nama_dusun ?? 'Dusun Kelurahan Notoharjo' }}, 
                            Kec. Trimurjo, Kab. Lampung Tengah.
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pernyataan Spesifik Surat -->
            <p>
                Berdasarkan data dan catatan kependudukan yang ada pada Kantor Kelurahan Notoharjo, nama yang bersangkutan di atas adalah benar-benar warga penduduk Kelurahan Notoharjo, Kecamatan Trimurjo, Kabupaten Lampung Tengah yang berkelakuan baik.
            </p>

            <p>
                Surat keterangan ini diberikan kepada yang bersangkutan untuk keperluan: 
                <strong class="uppercase font-bold underline">{{ $permohonan->keperluan }}</strong>.
                @if($permohonan->keterangan_tambahan)
                    <br><span>Catatan: {{ $permohonan->keterangan_tambahan }}</span>
                @endif
            </p>

            <p>
                Demikian Surat Keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan agar dapat dipergunakan sebagaimana mestinya.
            </p>
        </div>

        <!-- TANDA TANGAN PEJABAT -->
        <div class="mt-12 flex justify-end items-end">

            <!-- Tanda Tangan Lurah -->
            <div class="text-center w-64 space-y-1">
                <p class="text-sm m-0">Notoharjo, {{ $permohonan->tanggal_disahkan ? $permohonan->tanggal_disahkan->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</p>
                <p class="text-sm font-bold uppercase m-0">Kepala Kelurahan Notoharjo</p>
                
                <!-- Digital Signature Stamp Box -->
                <div class="h-20 flex items-center justify-center">
                    <div class="text-[10px] text-emerald-800 font-sans border-2 border-emerald-600 px-3 py-1 rounded-lg bg-emerald-50/50 uppercase font-bold tracking-wider">
                        <span class="block text-xs">Telah Disahkan Secara Elektronik</span>
                        <span class="font-mono text-[9px]">BS-{{ substr(md5($permohonan->token_qr), 0, 8) }}</span>
                    </div>
                </div>

                <p class="text-sm font-bold underline uppercase m-0">{{ $lurah->name ?? 'BAMBANG SUNGKOWO' }}</p>
                <p class="text-xs text-slate-600 m-0 font-sans">NIP. 19720510 199803 1 004</p>
            </div>
        </div>
    </div>

</body>
</html>

