<div class="overflow-x-auto">
    <table class="w-full text-left text-xs sm:text-sm">
        <thead>
            <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                <th class="py-3.5 px-6 font-bold">NIK & Nama Lengkap</th>
                <th class="py-3.5 px-6 font-bold">Nomor KK</th>
                <th class="py-3.5 px-6 font-bold">L/P</th>
                <th class="py-3.5 px-6 font-bold">Tempat, Tgl Lahir</th>
                <th class="py-3.5 px-6 font-bold">Wilayah Dusun & RT</th>
                <th class="py-3.5 px-6 font-bold">Pekerjaan</th>
                <th class="py-3.5 px-6 font-bold text-center">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($daftarPenduduk as $p)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-4 px-6">
                        <strong class="text-slate-900 block text-xs sm:text-sm">{{ $p->nama_lengkap }}</strong>
                        <span class="font-mono text-emerald-700 text-xs font-bold">{{ $p->nik }}</span>
                    </td>
                    <td class="py-4 px-6 font-mono text-xs text-slate-700">
                        {{ $p->kartuKeluarga->nomor_kk ?? '-' }}
                    </td>
                    <td class="py-4 px-6 font-semibold">
                        <span class="px-2 py-0.5 rounded text-xs {{ $p->jenis_kelamin === 'L' ? 'bg-sky-100 text-sky-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $p->jenis_kelamin }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-slate-600 text-xs">
                        {{ $p->tempat_lahir }}, {{ $p->tanggal_lahir ? $p->tanggal_lahir->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td class="py-4 px-6 text-slate-700 text-xs">
                        <span class="font-semibold block text-slate-800">{{ $p->kartuKeluarga->rt->dusun->nama_dusun ?? 'Dusun' }}</span>
                        <span class="block text-slate-400 text-[11px]">RT {{ $p->kartuKeluarga->rt->nomor_rt ?? '-' }} / RW {{ $p->kartuKeluarga->rt->nomor_rw ?? '-' }}</span>
                    </td>
                    <td class="py-4 px-6 text-slate-700 text-xs">
                        {{ $p->pekerjaan->nama_pekerjaan ?? '-' }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($p->status_keberadaan === 'Aktif')
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">
                                Aktif
                            </span>
                        @elseif($p->status_keberadaan === 'Meninggal')
                            <span class="px-2.5 py-1 bg-slate-200 text-slate-700 text-xs font-bold rounded-full">
                                Meninggal
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">
                                {{ $p->status_keberadaan }}
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-xs text-slate-400">
                        <div class="space-y-1">
                            <i class="fa-solid fa-user-slash text-2xl text-slate-300 mb-2 block"></i>
                            <p class="font-bold text-slate-600">Tidak ada data warga yang cocok dengan kriteria pencarian/filter.</p>
                            <p class="text-[11px] text-slate-400">Coba ubah kata kunci atau setel ulang filter pencarian.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
    <div>
        Menampilkan <strong>{{ $daftarPenduduk->firstItem() ?? 0 }}</strong> - <strong>{{ $daftarPenduduk->lastItem() ?? 0 }}</strong> dari <strong>{{ $daftarPenduduk->total() }}</strong> warga
    </div>
    <div class="ajax-pagination">
        {{ $daftarPenduduk->links() }}
    </div>
</div>

