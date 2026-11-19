@extends('layouts.app')

@section('title', 'Kalender Agenda & Kegiatan - Kelurahan Notoharjo')

@section('content')
<!-- Hero Header -->
<div class="bg-gradient-to-br from-emerald-900 via-emerald-800 to-slate-900 text-white py-14 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-3">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Jadwal & Agenda Publik</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kalender Kegiatan Kelurahan Notoharjo</h1>
        <p class="text-slate-300 mt-2 text-sm sm:text-base max-w-2xl leading-relaxed">
            Informasi resmi agenda musyawarah, posyandu balita & lansia, gotong royong warga, serta kegiatan pemerintahan di Kelurahan Notoharjo.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <!-- Filter & Search Toolbar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm">
        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-2 text-xs font-bold">
            <a href="{{ route('agenda.index', ['status' => 'semua', 'q' => $cari]) }}" 
               class="px-4 py-2 rounded-xl transition {{ $filter === 'semua' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Semua Agenda
            </a>
            <a href="{{ route('agenda.index', ['status' => 'mendatang', 'q' => $cari]) }}" 
               class="px-4 py-2 rounded-xl transition flex items-center space-x-1.5 {{ $filter === 'mendatang' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <span>Akan Datang</span>
                @if($totalMendatang > 0)
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $filter === 'mendatang' ? 'bg-emerald-800 text-white' : 'bg-emerald-100 text-emerald-700' }}">{{ $totalMendatang }}</span>
                @endif
            </a>
            <a href="{{ route('agenda.index', ['status' => 'selesai', 'q' => $cari]) }}" 
               class="px-4 py-2 rounded-xl transition flex items-center space-x-1.5 {{ $filter === 'selesai' ? 'bg-slate-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <span>Telah Berlangsung</span>
                @if($totalSelesai > 0)
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $filter === 'selesai' ? 'bg-slate-700 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalSelesai }}</span>
                @endif
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('agenda.index') }}" method="GET" class="relative max-w-sm w-full">
            <input type="hidden" name="status" value="{{ $filter }}">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="q" value="{{ $cari }}" placeholder="Cari nama kegiatan atau lokasi..." 
                   class="w-full pl-9 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
            @if($cari)
                <a href="{{ route('agenda.index', ['status' => $filter]) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Agenda Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($agendaList as $agenda)
            @php
                $isUpcoming = $agenda->tanggal_mulai >= now()->startOfDay();
            @endphp
            <div class="reveal bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-start justify-between gap-4">
                        <!-- Date Badge -->
                        <div class="shrink-0 text-center px-4 py-3 rounded-2xl {{ $isUpcoming ? 'bg-emerald-50 border border-emerald-200 text-emerald-800' : 'bg-slate-100 border border-slate-200 text-slate-600' }}">
                            <span class="block text-2xl font-black leading-none">{{ $agenda->tanggal_mulai->format('d') }}</span>
                            <span class="block text-[11px] font-bold uppercase mt-1 tracking-wider">{{ $agenda->tanggal_mulai->translatedFormat('M Y') }}</span>
                        </div>

                        <!-- Status & Penyelenggara -->
                        <div class="text-right space-y-1">
                            @if($isUpcoming)
                                <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Akan Datang</span>
                                </span>
                            @else
                                <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                    Telah Berlangsung
                                </span>
                            @endif
                            <span class="block text-[11px] text-slate-400 font-medium truncate max-w-[200px]">
                                {{ $agenda->penyelenggara ?? 'Pemerintah Kelurahan' }}
                            </span>
                        </div>
                    </div>

                    <!-- Title & Details -->
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition leading-snug mb-2">
                            {{ $agenda->nama_kegiatan }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">
                            {{ $agenda->deskripsi }}
                        </p>
                    </div>

                    <!-- Info Meta -->
                    <div class="space-y-2 pt-2 text-xs text-slate-500 border-t border-slate-100">
                        <div class="flex items-center space-x-2">
                            <i class="fa-regular fa-clock text-emerald-600 w-4 text-center shrink-0"></i>
                            <span>
                                {{ $agenda->tanggal_mulai->translatedFormat('l, d F Y') }} • Pukul {{ $agenda->tanggal_mulai->format('H:i') }} WIB
                                @if($agenda->tanggal_selesai)
                                    s/d {{ $agenda->tanggal_selesai->format('H:i') }} WIB
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-location-dot text-rose-500 w-4 text-center shrink-0"></i>
                            <span class="font-medium text-slate-700">{{ $agenda->lokasi }}</span>
                        </div>
                    </div>
                </div>

                @if($isUpcoming)
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-emerald-700 font-semibold">
                            <i class="fa-solid fa-bell mr-1"></i> Terbuka untuk seluruh warga
                        </span>
                        <span class="text-slate-400">
                            {{ $agenda->tanggal_mulai->diffForHumans() }}
                        </span>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-200">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3">
                    <i class="fa-regular fa-calendar-xmark"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-base mb-1">Tidak ada agenda yang ditemukan</h4>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">
                    @if($cari)
                        Tidak ada kegiatan yang sesuai dengan kata kunci "{{ $cari }}".
                    @else
                        Belum ada kegiatan yang terdaftar dalam kalender untuk kategori ini.
                    @endif
                </p>
                @if($cari || $filter !== 'semua')
                    <a href="{{ route('agenda.index') }}" class="inline-block mt-4 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition">
                        Reset Filter
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($agendaList->hasPages())
        <div class="pt-6">
            {{ $agendaList->links() }}
        </div>
    @endif
</div>
@endsection

