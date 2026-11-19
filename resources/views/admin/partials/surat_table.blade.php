<div class="overflow-x-auto">
    <table class="w-full text-left text-xs sm:text-sm">
        <thead>
            <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                <th class="py-3.5 px-6 font-bold">Token & Tanggal</th>
                <th class="py-3.5 px-6 font-bold">Jenis Surat</th>
                <th class="py-3.5 px-6 font-bold">Warga Pemohon</th>
                <th class="py-3.5 px-6 font-bold">Nomor Surat Resmi</th>
                <th class="py-3.5 px-6 font-bold text-center">Status Tahapan</th>
                <th class="py-3.5 px-6 font-bold text-center">Tindakan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($daftarSurat as $surat)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-4 px-6">
                        <span class="font-mono text-emerald-700 font-bold block">{{ $surat->token_qr }}</span>
                        <span class="text-xs text-slate-400">
                            {{ $surat->tanggal_pengajuan ? $surat->tanggal_pengajuan->translatedFormat('d M Y') : $surat->created_at->translatedFormat('d M Y') }}
                        </span>
                    </td>
                    <td class="py-4 px-6 font-semibold text-slate-900">
                        {{ $surat->kodeSurat->nama_surat }}
                    </td>
                    <td class="py-4 px-6">
                        <strong class="text-slate-900 block text-xs sm:text-sm">{{ $surat->penduduk->nama_lengkap }}</strong>
                        <span class="text-[11px] text-slate-400 font-mono">NIK: {{ $surat->penduduk->nik }}</span>
                    </td>
                    <td class="py-4 px-6 font-mono text-xs text-slate-700">
                        @if($surat->nomor_surat)
                            <span class="font-semibold text-slate-800 bg-slate-100 px-2 py-0.5 rounded">{{ $surat->nomor_surat }}</span>
                        @else
                            <span class="text-slate-400 italic">Belum Dinomori</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($surat->status === 'menunggu_verifikasi')
                            <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full inline-block">Verifikasi Kasi</span>
                        @elseif($surat->status === 'diverifikasi_kasi')
                            <span class="px-3 py-1 bg-sky-100 text-sky-800 text-xs font-bold rounded-full inline-block">Paraf Sekdes</span>
                        @elseif($surat->status === 'diparaf_sekretaris')
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-bold rounded-full inline-block">TTD Lurah</span>
                        @elseif($surat->status === 'selesai')
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full inline-block">Selesai / Sah</span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-800 text-xs font-bold rounded-full inline-block">Ditolak</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.surat.detail', $surat->id_permohonan_surat) }}" class="px-3 py-1.5 bg-slate-900 hover:bg-emerald-600 text-white font-bold rounded-lg text-xs transition">
                                Periksa Berkas
                            </a>
                            @if($surat->status === 'selesai')
                                <a href="{{ route('admin.surat.cetak', $surat->id_permohonan_surat) }}" target="_blank" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs transition flex items-center space-x-1" title="Cetak Surat Resmi">
                                    <i class="fa-solid fa-print"></i>
                                    <span>Cetak</span>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-xs text-slate-400">
                        <div class="space-y-1">
                            <i class="fa-solid fa-folder-open text-2xl text-slate-300 mb-2 block"></i>
                            <p class="font-bold text-slate-600">Tidak ada permohonan surat yang cocok dengan kriteria filter.</p>
                            <p class="text-[11px] text-slate-400">Silakan ubah pilihan status atau kata kunci pencarian.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
    <div>
        Menampilkan <strong>{{ $daftarSurat->firstItem() ?? 0 }}</strong> - <strong>{{ $daftarSurat->lastItem() ?? 0 }}</strong> dari <strong>{{ $daftarSurat->total() }}</strong> permohonan
    </div>
    <div class="ajax-pagination">
        {{ $daftarSurat->links() }}
    </div>
</div>

