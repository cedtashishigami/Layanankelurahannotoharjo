@extends('layouts.warga')

@section('title', 'Riwayat Surat Saya - Kelurahan Notoharjo')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Riwayat & Tracking Surat Saya</h1>
            <p class="text-xs text-slate-500">Daftar seluruh surat administrasi yang telah Anda ajukan</p>
        </div>
        <a href="{{ route('warga.surat.create') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs sm:text-sm transition flex items-center space-x-2 self-start sm:self-auto shadow-sm">
            <i class="fa-solid fa-plus"></i>
            <span>Ajukan Surat Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                        <th class="py-3.5 px-6 font-bold">Tanggal & Token</th>
                        <th class="py-3.5 px-6 font-bold">Jenis Surat</th>
                        <th class="py-3.5 px-6 font-bold">Pemohon / Subjek</th>
                        <th class="py-3.5 px-6 font-bold">Nomor Surat Resmi</th>
                        <th class="py-3.5 px-6 font-bold text-center">Status</th>
                        <th class="py-3.5 px-6 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($daftarSurat as $surat)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <span class="font-mono text-emerald-700 font-bold block">{{ $surat->token_qr }}</span>
                                <span class="text-xs text-slate-400">{{ $surat->tanggal_pengajuan->translatedFormat('d M Y') }}</span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-900">
                                {{ $surat->kodeSurat->nama_surat }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-slate-800 font-medium block">{{ $surat->penduduk->nama_lengkap }}</span>
                                <span class="text-[11px] text-slate-400 font-mono">NIK: {{ $surat->penduduk->nik }}</span>
                            </td>
                            <td class="py-4 px-6 font-mono text-xs text-slate-700">
                                {{ $surat->nomor_surat ?? '— (Belum Terbit)' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($surat->status === 'menunggu_verifikasi')
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Verifikasi Berkas</span>
                                @elseif($surat->status === 'diverifikasi_kasi')
                                    <span class="px-3 py-1 bg-sky-100 text-sky-800 text-xs font-bold rounded-full">Paraf Sekdes</span>
                                @elseif($surat->status === 'diparaf_sekretaris')
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-bold rounded-full">Tanda Tangan Lurah</span>
                                @elseif($surat->status === 'selesai')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Selesai / Sah</span>
                                @else
                                    <span class="px-3 py-1 bg-rose-100 text-rose-800 text-xs font-bold rounded-full">Ditolak</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('warga.surat.detail', $surat->id_permohonan_surat) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition">
                                        Detail
                                    </a>
                                    @if($surat->status === 'selesai')
                                        <a href="{{ route('admin.surat.cetak', $surat->id_permohonan_surat) }}" target="_blank" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs transition flex items-center space-x-1">
                                            <i class="fa-solid fa-print"></i>
                                            <span>Unduh</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-xs text-slate-400">
                                Anda belum memiliki pengajuan surat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $daftarSurat->links() }}
        </div>
    </div>
</div>
@endsection

