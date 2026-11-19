@extends('layouts.admin')

@section('title', 'Kelola Agenda Kegiatan - Kelurahan Notoharjo')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Agenda & Jadwal Kegiatan</h1>
        <p class="text-xs text-slate-500">Kelola kalender kegiatan kelurahan, posyandu, musrenbang, dan kegiatan warga lainnya</p>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold flex items-center space-x-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Tambah Agenda -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center space-x-2">
                <i class="fa-solid fa-calendar-plus text-emerald-600"></i>
                <span>Jadwalkan Kegiatan Baru</span>
            </h3>

            <form action="{{ route('admin.agenda.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" required placeholder="Contoh: Musyawarah Rencana Pembangunan Kelurahan (Musrenbangkel)" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Tempat</label>
                    <input type="text" name="lokasi" required placeholder="Contoh: Balai Pertemuan Kelurahan Notoharjo" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Waktu Pelaksanaan</label>
                    <input type="datetime-local" name="tanggal_mulai" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Penyelenggara / Penanggung Jawab</label>
                    <input type="text" name="penyelenggara" placeholder="Contoh: Seksi Pembangunan & LPMK" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan / Agenda Tambahan</label>
                    <textarea name="deskripsi" rows="3" placeholder="Uraian kegiatan atau persiapan yang perlu dibawa warga..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition shadow-sm shadow-emerald-500/20 flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Simpan Agenda Kegiatan</span>
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Agenda -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Daftar Jadwal Kegiatan Kelurahan</h3>
                <span class="text-xs text-slate-500">Total: {{ $agendaList->total() }}</span>
            </div>

            <div class="overflow-x-auto flex-grow">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-100 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="p-4">Nama Kegiatan & Lokasi</th>
                            <th class="p-4">Waktu</th>
                            <th class="p-4">Penyelenggara</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($agendaList as $a)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="p-4">
                                    <span class="font-bold text-slate-900 block text-xs">{{ $a->nama_kegiatan }}</span>
                                    <span class="text-[11px] text-slate-500 block mt-0.5">
                                        <i class="fa-solid fa-location-dot mr-1 text-rose-500"></i>{{ $a->lokasi }}
                                    </span>
                                    @if($a->deskripsi)
                                        <span class="text-[10px] text-slate-400 block mt-1 italic">{{ $a->deskripsi }}</span>
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    <span class="font-semibold text-slate-800 block text-xs">
                                        {{ \Carbon\Carbon::parse($a->tanggal_mulai)->translatedFormat('d F Y') }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 block font-mono">
                                        Pukul {{ \Carbon\Carbon::parse($a->tanggal_mulai)->format('H:i') }} WIB
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="font-semibold text-slate-800 block">{{ $a->penyelenggara ?? 'Kelurahan Notoharjo' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-slate-400">Belum ada agenda terjadwal. Tambahkan agenda kegiatan melalui formulir di samping.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($agendaList->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $agendaList->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

