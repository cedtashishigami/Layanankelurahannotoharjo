@extends('layouts.app')

@section('title', 'Galeri Foto & Video - Kelurahan Notoharjo')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-emerald-900 via-emerald-800 to-slate-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-4">
            <i class="fa-solid fa-images"></i>
            <span>Dokumentasi Visual Kelurahan</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Galeri Foto & Video</h1>
        <p class="mt-3 text-slate-300 max-w-xl mx-auto text-sm">Dokumentasi kegiatan, pembangunan, dan potensi Kelurahan Notoharjo, Kecamatan Trimurjo, Kabupaten Lampung Tengah.</p>
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if($galeri->total() === 0)
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-images text-3xl text-slate-400"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Media Galeri</h3>
            <p class="text-slate-500 text-sm mt-2">Galeri akan segera diperbarui oleh aparat kelurahan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($galeri as $item)
                <div class="reveal bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="aspect-video overflow-hidden bg-slate-100 relative">
                        @if($item->jenis_media === 'video')
                            <div class="w-full h-full flex items-center justify-center bg-slate-900">
                                <i class="fa-solid fa-circle-play text-5xl text-white/70 group-hover:text-white transition"></i>
                            </div>
                        @else
                            @php
                                $mediaUrl = Str::startsWith($item->file_media, ['http://', 'https://']) 
                                    ? $item->file_media 
                                    : asset($item->file_media);
                            @endphp
                            <img src="{{ $mediaUrl }}" alt="{{ $item->judul }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full {{ $item->jenis_media === 'video' ? 'bg-rose-600 text-white' : 'bg-emerald-600 text-white' }}">
                                {{ $item->jenis_media === 'video' ? 'Video' : 'Foto' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-slate-900 text-sm">{{ $item->judul }}</h3>
                        @if($item->keterangan)
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $item->keterangan }}</p>
                        @endif
                        <p class="text-[10px] text-slate-400 font-mono mt-2">
                            <i class="fa-regular fa-clock mr-1"></i>{{ $item->created_at->format('d M Y') }}
                            @if($item->petugas)
                                &bull; {{ $item->petugas->name }}
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $galeri->links() }}
        </div>
    @endif
</section>
@endsection

