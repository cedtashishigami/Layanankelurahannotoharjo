@extends('layouts.app')

@section('title', $berita->judul . ' - Kelurahan Notoharjo')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('berita.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center space-x-1.5 mb-6">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Kembali ke Indeks Berita</span>
    </a>

    <article class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm">
        <div class="flex items-center space-x-3 text-xs text-slate-400 mb-4">
            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full font-semibold">Pengumuman Resmi</span>
            <span>•</span>
            <span><i class="fa-regular fa-calendar mr-1"></i>{{ $berita->created_at->translatedFormat('d F Y') }}</span>
            <span>•</span>
            <span><i class="fa-regular fa-eye mr-1"></i>{{ $berita->views }} kali dibaca</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight mb-6">
            {{ $berita->judul }}
        </h1>

        @if($berita->gambar)
            <div class="mb-8 rounded-2xl overflow-hidden aspect-video max-h-96 w-full shadow-md">
                <img src="{{ Str::startsWith($berita->gambar, ['http://', 'https://']) ? $berita->gambar : asset($berita->gambar) }}" 
                     alt="{{ $berita->judul }}" 
                     class="w-full h-full object-cover">
            </div>
        @endif

        <div class="prose max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4 border-t border-slate-100 pt-6">
            {!! $berita->isi_berita !!}
        </div>
    </article>

    @if($beritaLainnya->count() > 0)
        <div class="mt-14">
            <h3 class="text-lg font-bold text-slate-900 mb-6">Berita Lainnya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach($beritaLainnya as $bl)
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                        <span class="text-xs text-slate-400 block mb-1">{{ $bl->created_at->translatedFormat('d M Y') }}</span>
                        <h4 class="font-bold text-slate-900 text-sm hover:text-emerald-600 transition">
                            <a href="{{ route('berita.detail', $bl->slug) }}">{{ $bl->judul }}</a>
                        </h4>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

