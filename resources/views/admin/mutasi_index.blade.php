@extends('layouts.admin')

@section('title', 'Mutasi Penduduk - Kelurahan Notoharjo')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pencatatan Mutasi Kependudukan</h1>
        <p class="text-xs text-slate-500">Mencatat peristiwa vital: Kelahiran, Kematian, Pindah Masuk, dan Pindah Keluar</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Tambah Mutasi -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Catat Peristiwa Baru</h3>

            <form action="{{ route('admin.mutasi.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Warga Terkait</label>
                    <select name="id_penduduk" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 font-medium">
                        <option value="">-- Pilih Nama Warga --</option>
                        @foreach($pendudukList as $pen)
                            <option value="{{ $pen->id_penduduk }}">{{ $pen->nama_lengkap }} (NIK: {{ $pen->nik }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Peristiwa</label>
                    <select name="jenis_mutasi" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 font-medium">
                        <option value="Kematian">Kematian (Meninggal Dunia)</option>
                        <option value="Pindah_Keluar">Pindah Domisili Keluar</option>
                        <option value="Pindah_Masuk">Pindah Masuk</option>
                        <option value="Kelahiran">Kelahiran Baru</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Kejadian</label>
                    <input type="date" name="tanggal_kejadian" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Surat Pengantar / Keterangan</label>
                    <input type="text" name="nomor_surat_keterangan" placeholder="Contoh: 472.12/05/NT/2026" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alasan / Keterangan Tambahan</label>
                    <textarea name="alasan_tujuan" rows="3" placeholder="Contoh: Pindah domisili ke Kecamatan Metro Barat mengikuti keluarga" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-emerald-600 text-white font-bold rounded-xl text-xs sm:text-sm transition shadow-sm">
                    Simpan Peristiwa Mutasi
                </button>
            </form>
        </div>

        <!-- Tabel Riwayat Mutasi -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm">Riwayat Catatan Mutasi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                            <th class="py-3 px-6 font-bold">Tanggal</th>
                            <th class="py-3 px-6 font-bold">Warga</th>
                            <th class="py-3 px-6 font-bold">Peristiwa</th>
                            <th class="py-3 px-6 font-bold">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($mutasi as $m)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-6 text-slate-500 text-xs">
                                    {{ $m->tanggal_kejadian->translatedFormat('d M Y') }}
                                </td>
                                <td class="py-3.5 px-6">
                                    <strong class="text-slate-900 block">{{ $m->penduduk->nama_lengkap }}</strong>
                                    <span class="text-[11px] text-slate-400 font-mono">NIK: {{ $m->penduduk->nik }}</span>
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $m->jenis_mutasi === 'Kematian' ? 'bg-rose-100 text-rose-800' : ($m->jenis_mutasi === 'Pindah_Keluar' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                        {{ str_replace('_', ' ', $m->jenis_mutasi) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-xs text-slate-600">
                                    {{ $m->alasan_tujuan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-xs text-slate-400">
                                    Belum ada data mutasi yang dicatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $mutasi->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

