@extends('layouts.admin')

@section('title', 'Kelola Berita & Publikasi - Kelurahan Notoharjo')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Berita & Publikasi</h1>
        <p class="text-xs text-slate-500">Kelola rilis berita, informasi pembangunan, dan pengumuman resmi untuk masyarakat Kelurahan Notoharjo</p>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold flex items-center space-x-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Tambah Berita -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center space-x-2">
                <i class="fa-solid fa-pen-to-square text-emerald-600"></i>
                <span>Tulis Berita / Pengumuman Baru</span>
            </h3>

            <form action="{{ route('admin.berita.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Berita</label>
                    <input type="text" name="judul" required placeholder="Contoh: Gotong Royong Saluran Irigasi Bedeng 17" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Ringkasan Singkat (Lead)</label>
                    <textarea name="ringkasan" rows="2" placeholder="Ringkasan 1-2 kalimat untuk kartu berita..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Isi Berita Lengkap</label>
                    <textarea name="isi_berita" rows="8" required placeholder="Tuliskan isi berita secara lengkap di sini..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Publikasi</label>
                    <select name="status" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="published">Langsung Publikasikan (Tayang)</option>
                        <option value="draft">Simpan Sebagai Draf</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition shadow-sm shadow-emerald-500/20 flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Publikasikan Berita</span>
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Berita -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Daftar Berita & Artikel Terkini</h3>
                <span class="text-xs text-slate-500">Total: {{ $beritaList->total() }}</span>
            </div>

            <div class="overflow-x-auto flex-grow">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-100 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="p-4">Judul & Ringkasan</th>
                            <th class="p-4">Penulis</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($beritaList as $b)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="p-4">
                                    <span class="font-bold text-slate-900 block text-xs line-clamp-1">{{ $b->judul }}</span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5 line-clamp-1">{{ $b->ringkasan }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono mt-1 block">
                                        <i class="fa-regular fa-clock mr-1"></i>{{ $b->created_at->format('d M Y H:i') }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="font-semibold text-slate-800 block">{{ $b->penulis->name ?? 'Admin' }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    @if($b->status === 'published')
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-bold">Tayang</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-[10px] font-bold">Draf</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('berita.detail', $b->slug) }}" target="_blank" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-bold transition inline-flex items-center space-x-1">
                                        <span>Lihat</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-400">Belum ada data berita. Silakan publikasikan rilis pertama melalui formulir di samping.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($beritaList->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $beritaList->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

