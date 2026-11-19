@extends('layouts.admin')

@section('title', 'Kelola Pasar Welit & Potensi - Kelurahan Notoharjo')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Pasar Welit & Potensi Kelurahan</h1>
        <p class="text-xs text-slate-500">Publikasi potensi ekonomi pertanian, komoditas pangan, dan UMKM warga</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Tambah Potensi -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Tambah Potensi / UMKM Baru</h3>

            <form action="{{ route('admin.potensi.store') }}" method="POST" class="space-y-3.5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Wilayah Dusun</label>
                    <select name="id_dusun" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                        @foreach($dusunList as $d)
                            <option value="{{ $d->id_dusun }}">{{ $d->nama_dusun }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Potensi / Usaha</label>
                    <input type="text" name="nama_potensi" required placeholder="Contoh: Penggilingan Padi Sri Rejeki" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori</label>
                    <select name="kategori" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="Pertanian">Pertanian Pangan & Holtikultura</option>
                        <option value="Pasar Tradisional / Perdagangan">Pasar Tradisional / Perdagangan</option>
                        <option value="UMKM & Industri Rumahan">UMKM & Industri Rumahan</option>
                        <option value="Peternakan">Peternakan</option>
                        <option value="Kuliner & Jasa">Kuliner & Jasa</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pengelola / Pemilik</label>
                    <input type="text" name="pemilik" placeholder="Contoh: Paguyuban Petani Notoharjo" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Alamat</label>
                    <input type="text" name="lokasi" placeholder="Contoh: Bedeng 18 Polos (Pasar Welit)" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kontak Telepon / WhatsApp</label>
                    <input type="text" name="kontak" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan keunggulan dan kapasitas produksi potensi ini..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-emerald-600 text-white font-bold rounded-xl text-xs sm:text-sm transition shadow-sm">
                    Simpan & Publikasikan
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Potensi -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm">Daftar Potensi Terdaftar</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                            <th class="py-3 px-6 font-bold">Nama Potensi & Kategori</th>
                            <th class="py-3 px-6 font-bold">Pengelola</th>
                            <th class="py-3 px-6 font-bold">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($potensi as $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-6">
                                    <strong class="text-slate-900 block">{{ $p->nama_potensi }}</strong>
                                    <span class="text-[11px] text-emerald-700 font-semibold">{{ $p->kategori }}</span>
                                </td>
                                <td class="py-3.5 px-6 text-slate-600 text-xs">
                                    {{ $p->pemilik ?? '-' }}
                                    @if($p->kontak)
                                        <span class="block text-slate-400 text-[10px]">{{ $p->kontak }}</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-6 text-slate-600 text-xs">
                                    {{ $p->lokasi ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-xs text-slate-400">
                                    Belum ada data potensi yang diinput.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $potensi->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

