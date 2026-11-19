@extends('layouts.app')

@section('title', 'Berita & Pengumuman - Kelurahan Notoharjo')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight">Kabar Desa & Berita Notoharjo</h1>
        <p class="text-emerald-200 mt-2 text-sm">Informasi terkini kegiatan pemerintahan dan kemasyarakatan Kelurahan Notoharjo</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($berita as $b)
            <article class="reveal bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col justify-between hover:shadow-lg transition group">
                <div>
                    @if($b->gambar)
                        <div class="aspect-video overflow-hidden bg-slate-100">
                            <img src="{{ Str::startsWith($b->gambar, ['http://', 'https://']) ? $b->gambar : asset($b->gambar) }}" 
                                 alt="{{ $b->judul }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center space-x-2 text-xs text-slate-400 mb-3">
                            <i class="fa-regular fa-calendar"></i>
                            <span>{{ $b->created_at->translatedFormat('d F Y') }}</span>
                            <span>•</span>
                            <span>{{ $b->views }}x dibaca</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition">
                            <a href="{{ route('berita.detail', $b->slug) }}">{{ $b->judul }}</a>
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                            {{ $b->ringkasan }}
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2 border-t border-slate-100">
                    <a href="{{ route('berita.detail', $b->slug) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center space-x-1">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-500 text-sm">
                Belum ada berita yang dipublikasikan.
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $berita->links() }}
    </div>
</div>
@endsection

