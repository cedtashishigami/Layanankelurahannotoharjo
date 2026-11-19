@extends('layouts.admin')

@section('title', 'Kelola Galeri Foto & Video - Kelurahan Notoharjo')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Galeri Foto & Video</h1>
        <p class="text-xs text-slate-500">Kelola dokumentasi visual kegiatan, pembangunan, dan potensi Kelurahan Notoharjo</p>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold flex items-center space-x-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Tambah Galeri -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center space-x-2">
                <i class="fa-solid fa-photo-film text-emerald-600"></i>
                <span>Tambah Media Baru</span>
            </h3>

            <form action="{{ route('admin.galeri.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Foto / Video</label>
                    <input type="text" name="judul" required placeholder="Contoh: Gotong Royong Bedeng 17 - Nov 2026" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Media</label>
                    <select name="jenis_media" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="foto">Foto / Gambar</option>
                        <option value="video">Video (YouTube / URL)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">URL Foto / Video</label>
                    <input type="url" name="file_media" required placeholder="https://..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                    <p class="text-[10px] text-slate-400 mt-1">Gunakan URL dari Google Drive, Imgur, atau YouTube untuk video.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="3" placeholder="Deskripsi singkat kegiatan atau foto..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition shadow-sm shadow-emerald-500/20 flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Tambahkan ke Galeri</span>
                </button>
            </form>
        </div>

        <!-- Grid Galeri -->
        <div class="lg:col-span-8 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Media Galeri Kelurahan</h3>
                <span class="text-xs text-slate-500">Total: {{ $galeri->total() }} item</span>
            </div>

            @if($galeri->total() === 0)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-12 text-center">
                    <i class="fa-solid fa-images text-3xl text-slate-300 mb-3 block"></i>
                    <p class="text-sm text-slate-500">Belum ada media. Tambahkan foto atau video melalui formulir di samping.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($galeri as $item)
                        <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm group">
                            <div class="aspect-video overflow-hidden bg-slate-100 relative">
                                @if($item->jenis_media === 'video')
                                    <div class="w-full h-full flex items-center justify-center bg-slate-900">
                                        <i class="fa-solid fa-circle-play text-4xl text-white/70"></i>
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
                                <div class="absolute top-2 left-2">
                                    <span class="px-1.5 py-0.5 text-[9px] font-bold uppercase rounded {{ $item->jenis_media === 'video' ? 'bg-rose-600 text-white' : 'bg-emerald-600 text-white' }}">
                                        {{ $item->jenis_media }}
                                    </span>
                                </div>
                                <form action="{{ route('admin.galeri.destroy', $item->id_galeri) }}" method="POST"
                                      onsubmit="return confirm('Hapus media ini dari galeri?')"
                                      class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-6 h-6 bg-rose-600 hover:bg-rose-700 text-white rounded-full text-[10px] flex items-center justify-center shadow">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="p-3">
                                <p class="font-bold text-slate-900 text-xs line-clamp-1">{{ $item->judul }}</p>
                                @if($item->keterangan)
                                    <p class="text-[10px] text-slate-400 mt-0.5 line-clamp-1">{{ $item->keterangan }}</p>
                                @endif
                                <p class="text-[10px] text-slate-400 font-mono mt-1">{{ $item->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $galeri->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

