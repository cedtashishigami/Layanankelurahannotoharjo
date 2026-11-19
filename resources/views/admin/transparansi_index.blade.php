@extends('layouts.admin')

@section('title', 'Kelola Transparansi Anggaran - Kelurahan Notoharjo')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Transparansi Anggaran (APBD)</h1>
        <p class="text-xs text-slate-500">Kelola publikasi keterbukaan informasi alokasi Dana Kelurahan Notoharjo</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Tambah Anggaran -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Input Alokasi Anggaran Baru</h3>

            <form action="{{ route('admin.transparansi.store') }}" method="POST" class="space-y-3.5">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tahun Anggaran</label>
                        <input type="number" name="tahun_anggaran" value="{{ date('Y') }}" required min="2020" max="2035" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis</label>
                        <select name="jenis" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 font-semibold">
                            <option value="Pendapatan">Pendapatan</option>
                            <option value="Belanja" selected>Belanja</option>
                            <option value="Pembiayaan">Pembiayaan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Bidang Penyelenggaraan</label>
                    <input type="text" name="bidang" required placeholder="Contoh: Pelaksanaan Pembangunan Kelurahan" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Uraian Kegiatan / Program</label>
                    <input type="text" name="uraian" required placeholder="Contoh: Pembangunan Drainase Pertanian Dusun 3" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pagu Target (Rp)</label>
                        <input type="number" name="target_anggaran" required placeholder="150000000" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Realisasi (Rp)</label>
                        <input type="number" name="realisasi_anggaran" required placeholder="148500000" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan Tambahan</label>
                    <textarea name="keterangan" rows="2" placeholder="Keterangan status pengerjaan atau pencairan dana..." class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-emerald-600 text-white font-bold rounded-xl text-xs sm:text-sm transition shadow-sm">
                    Simpan Data Anggaran
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Anggaran -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm">Daftar Anggaran Terpublikasi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                            <th class="py-3 px-6 font-bold">Tahun & Jenis</th>
                            <th class="py-3 px-6 font-bold">Uraian</th>
                            <th class="py-3 px-6 font-bold text-right">Target</th>
                            <th class="py-3 px-6 font-bold text-right">Realisasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($anggaran as $a)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-6">
                                    <strong class="text-slate-900 block font-mono">{{ $a->tahun_anggaran }}</strong>
                                    <span class="text-[11px] font-semibold {{ $a->jenis === 'Pendapatan' ? 'text-sky-600' : 'text-emerald-600' }}">{{ $a->jenis }}</span>
                                </td>
                                <td class="py-3.5 px-6">
                                    <strong class="text-slate-900 block">{{ $a->uraian }}</strong>
                                    <span class="text-slate-400 text-[11px]">{{ $a->bidang }}</span>
                                </td>
                                <td class="py-3.5 px-6 text-right font-mono text-slate-600">
                                    Rp {{ number_format($a->target_anggaran, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-6 text-right font-mono font-bold text-emerald-600">
                                    Rp {{ number_format($a->realisasi_anggaran, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-xs text-slate-400">
                                    Belum ada data anggaran yang diinput.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $anggaran->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

