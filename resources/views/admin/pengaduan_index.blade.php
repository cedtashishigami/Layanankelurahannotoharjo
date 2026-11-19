@extends('layouts.admin')

@section('title', 'Tindak Lanjut Aspirasi Warga - Kelurahan Notoharjo')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kanal Aspirasi & Pengaduan Warga</h1>
        <p class="text-xs text-slate-500">Berikan respon dan tindak lanjut atas masukan masyarakat Notoharjo</p>
    </div>

    <div class="space-y-4">
        @forelse($pengaduan as $aduan)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                    <div>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-full">
                            {{ $aduan->kategori }}
                        </span>
                        <h3 class="text-base font-bold text-slate-900 mt-2">{{ $aduan->judul_laporan }}</h3>
                        <span class="text-xs text-slate-400">
                            Oleh: <strong class="text-slate-700">{{ $aduan->pelapor->name }}</strong> • {{ $aduan->dusun->nama_dusun ?? 'Dusun' }} • {{ $aduan->created_at->translatedFormat('d F Y, H:i') }} WIB
                        </span>
                    </div>

                    <div>
                        @if($aduan->status === 'diajukan')
                            <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Menunggu Respon</span>
                        @elseif($aduan->status === 'dalam_tindakan')
                            <span class="px-3 py-1 bg-sky-100 text-sky-800 text-xs font-bold rounded-full">Dalam Tindakan</span>
                        @elseif($aduan->status === 'selesai')
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Selesai</span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-800 text-xs font-bold rounded-full">Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="text-xs sm:text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    {{ $aduan->isi_laporan }}
                </div>

                @if($aduan->foto_bukti)
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Foto Bukti Terlampir:</span>
                        <a href="{{ asset('storage/' . $aduan->foto_bukti) }}" target="_blank" class="inline-block px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-lg text-xs font-bold text-emerald-700 transition">
                            <i class="fa-solid fa-image mr-1"></i> Buka Foto Bukti
                        </a>
                    </div>
                @endif

                <!-- Form Tindak Lanjut -->
                <div class="pt-3 border-t border-slate-100">
                    <form action="{{ route('admin.pengaduan.tanggapi', $aduan->id_pengaduan) }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                            <div class="sm:col-span-1">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Penanganan</label>
                                <select name="status" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 font-semibold">
                                    <option value="ditinjau" {{ $aduan->status === 'ditinjau' ? 'selected' : '' }}>Ditinjau Petugas</option>
                                    <option value="dalam_tindakan" {{ $aduan->status === 'dalam_tindakan' ? 'selected' : '' }}>Sedang Ditindaklanjuti</option>
                                    <option value="selesai" {{ $aduan->status === 'selesai' ? 'selected' : '' }}>Selesai / Tuntas</option>
                                    <option value="ditolak" {{ $aduan->status === 'ditolak' ? 'selected' : '' }}>Ditolak / Luar Wewenang</option>
                                </select>
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggapan Resmi Kelurahan</label>
                                <div class="flex gap-2">
                                    <input type="text" name="tanggapan_petugas" value="{{ $aduan->tanggapan_petugas }}" required placeholder="Tuliskan respon resmi kelurahan kepada warga..." class="flex-grow px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition shadow-sm shrink-0">
                                        Kirim Respon
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 text-xs text-slate-400">
                Tidak ada aspirasi warga yang masuk.
            </div>
        @endforelse

        <div>
            {{ $pengaduan->links() }}
        </div>
    </div>
</div>
@endsection

