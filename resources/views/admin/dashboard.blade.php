@extends('layouts.admin')

@section('title', 'Dashboard Aparat - Kelurahan Notoharjo')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Ringkasan Sistem Informasi & Pelayanan</h1>
            <p class="text-xs text-slate-500">Monitoring data kependudukan, antrean persuratan, dan penanganan aspirasi</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.surat.index') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition shadow-sm flex items-center space-x-1.5">
                <i class="fa-solid fa-list-check"></i>
                <span>Kelola Surat Masuk</span>
            </a>
        </div>
    </div>

    <!-- Alert Permohonan Surat Tertunda > 2 Hari (Warning SLA) -->
    @if(isset($suratTertunda) && $suratTertunda->isNotEmpty())
        <div class="bg-amber-50 border-2 border-amber-400 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center text-lg shrink-0 animate-bounce">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-amber-950 text-sm">Peringatan: Ada {{ $suratTertunda->count() }} Permohonan Surat Tertunda Lebih Dari 2 Hari</h4>
                        <p class="text-xs text-amber-800">Segera tindak lanjuti permohonan berikut agar tidak melanggar standar waktu pelayanan (SLA) warga.</p>
                    </div>
                </div>
                <a href="{{ route('admin.surat.index', ['preset_tgl' => 'lama']) }}" class="hidden sm:inline-flex px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                    Tindak Lanjuti Semua
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 pt-2">
                @foreach($suratTertunda->take(3) as $st)
                    <div class="bg-white p-3.5 rounded-2xl border border-amber-200 shadow-sm flex items-center justify-between text-xs">
                        <div>
                            <span class="font-mono font-bold text-amber-700 block">{{ $st->token_qr }}</span>
                            <strong class="text-slate-900 block truncate max-w-[180px]">{{ $st->kodeSurat->nama_surat }}</strong>
                            <span class="text-slate-500 text-[11px]">{{ $st->penduduk->nama_lengkap }} • {{ $st->created_at->diffForHumans() }}</span>
                        </div>
                        <a href="{{ route('admin.surat.detail', $st->id_permohonan_surat) }}" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg text-[11px] transition shrink-0">
                            Proses &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Statistik Cards (6 Metrik Kunci yang Komprehensif) -->
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 sm:gap-6">
        <!-- 1. Total Warga -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-3.5">
            <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <span class="text-xl font-black text-slate-900">{{ number_format($statistik['total_penduduk']) }}</span>
                <span class="text-[11px] text-slate-500 block leading-tight">Warga Aktif</span>
            </div>
        </div>

        <!-- 2. Surat Masuk Hari Ini -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-3.5">
            <div class="w-11 h-11 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-inbox"></i>
            </div>
            <div>
                <span class="text-xl font-black text-emerald-700">{{ $statistik['surat_hari_ini'] ?? 0 }}</span>
                <span class="text-[11px] text-slate-500 block leading-tight">Surat Hari Ini</span>
            </div>
        </div>

        <!-- 3. Surat Butuh Tindakan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-3.5">
            <div class="w-11 h-11 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <span class="text-xl font-black text-amber-600">{{ $statistik['surat_pending_total'] ?? 0 }}</span>
                <span class="text-[11px] text-slate-500 block leading-tight">Menunggu Proses</span>
            </div>
        </div>

        <!-- 4. Surat Selesai & Persentase -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-3.5">
            <div class="w-11 h-11 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <span class="text-xl font-black text-sky-700">{{ $statistik['surat_selesai'] }}</span>
                <span class="text-[11px] text-slate-500 block leading-tight">Selesai ({{ $statistik['rate_penyelesaian'] ?? 100 }}%)</span>
            </div>
        </div>

        <!-- 5. Warga Baru Bulan Ini -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-3.5">
            <div class="w-11 h-11 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <div>
                <span class="text-xl font-black text-indigo-700">{{ $statistik['warga_baru_bulan_ini'] ?? 0 }}</span>
                <span class="text-[11px] text-slate-500 block leading-tight">Warga Baru Bln Ini</span>
            </div>
        </div>

        <!-- 6. Pengaduan Pending -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-3.5">
            <div class="w-11 h-11 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <div>
                <span class="text-xl font-black text-rose-600">{{ $statistik['pengaduan_pending'] }}</span>
                <span class="text-[11px] text-slate-500 block leading-tight">Aspirasi Belum Dijawab</span>
            </div>
        </div>
    </div>

    <!-- Grafik Tren Permohonan Surat (Chart Baru) -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Tren Permohonan Surat Pelayanan (6 Bulan Terakhir)</h3>
                <p class="text-[11px] text-slate-400">Statistik jumlah permohonan masuk vs surat yang berhasil disahkan</p>
            </div>
            <div class="flex items-center space-x-4 text-xs font-semibold">
                <span class="flex items-center space-x-1.5 text-slate-700">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                    <span>Total Pengajuan</span>
                </span>
                <span class="flex items-center space-x-1.5 text-slate-700">
                    <span class="w-3 h-3 rounded-full bg-sky-500 inline-block"></span>
                    <span>Surat Selesai / Terbit</span>
                </span>
            </div>
        </div>
        <div class="h-64 relative">
            <canvas id="trenSuratChart"></canvas>
        </div>
    </div>

    <!-- Visualisasi Grafik Demografi & Mata Pencaharian -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Grafik Distribusi Dusun -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Distribusi Penduduk Berdasarkan Wilayah Dusun</h3>
                    <p class="text-[11px] text-slate-400">Total warga aktif tercatat di 8 wilayah Dusun Kelurahan Notoharjo</p>
                </div>
                <span class="text-xs font-mono font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg">
                    {{ $statistik['total_penduduk'] }} Jiwa
                </span>
            </div>
            <div class="h-64 relative">
                <canvas id="dusunChart"></canvas>
            </div>
        </div>

        <!-- Grafik Mata Pencaharian -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Sektor Mata Pencaharian Utama</h3>
                    <p class="text-[11px] text-slate-400">Komposisi profesi masyarakat Notoharjo</p>
                </div>
                <div class="flex items-center space-x-2 text-[10px] font-bold">
                    <span class="text-sky-700"><i class="fa-solid fa-mars mr-1"></i>{{ $statistik['penduduk_laki'] }} L</span>
                    <span class="text-pink-700"><i class="fa-solid fa-venus mr-1"></i>{{ $statistik['penduduk_perempuan'] }} P</span>
                </div>
            </div>
            <div class="h-64 relative flex items-center justify-center">
                <canvas id="pekerjaanChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Grid Surat Terkini & Pengaduan Warga -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Permohonan Surat Masuk Terbaru -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm">Antrean Pelayanan Surat Mandiri</h3>
                <a href="{{ route('admin.surat.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua Antrean</a>
            </div>

            <div class="space-y-3">
                @forelse($suratTerbaru as $st)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-3 text-xs">
                        <div>
                            <span class="font-mono text-emerald-700 font-bold block">{{ $st->token_qr }}</span>
                            <strong class="text-slate-900 block mt-0.5">{{ $st->kodeSurat->nama_surat }}</strong>
                            <span class="text-slate-500">Pemohon: {{ $st->penduduk->nama_lengkap }} (NIK: {{ $st->penduduk->nik }})</span>
                        </div>
                        <div class="text-right shrink-0">
                            @if($st->status === 'menunggu_verifikasi')
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-[11px] font-bold rounded-full block mb-1">Verifikasi Kasi</span>
                            @elseif($st->status === 'diverifikasi_kasi')
                                <span class="px-2.5 py-1 bg-sky-100 text-sky-800 text-[11px] font-bold rounded-full block mb-1">Paraf Sekdes</span>
                            @elseif($st->status === 'diparaf_sekretaris')
                                <span class="px-2.5 py-1 bg-indigo-100 text-indigo-800 text-[11px] font-bold rounded-full block mb-1">TTD Lurah</span>
                            @elseif($st->status === 'selesai')
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-[11px] font-bold rounded-full block mb-1">Selesai</span>
                            @else
                                <span class="px-2.5 py-1 bg-rose-100 text-rose-800 text-[11px] font-bold rounded-full block mb-1">Ditolak</span>
                            @endif
                            <a href="{{ route('admin.surat.detail', $st->id_permohonan_surat) }}" class="text-[11px] font-bold text-slate-700 hover:text-emerald-600 underline">
                                Buka Berkas
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-slate-400">
                        Tidak ada antrean surat saat ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Aspirasi Warga Menunggu Respon -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm">Aspirasi Warga Terbaru</h3>
                <a href="{{ route('admin.pengaduan.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Semua Aduan</a>
            </div>

            <div class="space-y-3">
                @forelse($pengaduanTerbaru as $aduan)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-0.5 bg-slate-200 text-slate-700 font-semibold rounded text-[10px]">
                                {{ $aduan->kategori }}
                            </span>
                            <span class="text-[10px] text-slate-400">{{ $aduan->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="font-bold text-slate-900">{{ $aduan->judul_laporan }}</h4>
                        <p class="text-slate-600 line-clamp-2">{{ $aduan->isi_laporan }}</p>
                        <div class="pt-1">
                            <a href="{{ route('admin.pengaduan.index') }}" class="text-[11px] font-bold text-emerald-600 hover:underline">
                                Berikan Tanggapan & Tindak Lanjut &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-slate-400">
                        Belum ada aspirasi masyarakat yang masuk.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 0. Chart Tren Permohonan Surat (6 Bulan Terakhir)
    const trenCtx = document.getElementById('trenSuratChart').getContext('2d');
    const trenLabels = {!! json_encode($grafikTren->pluck('bulan')) !!};
    const trenTotalData = {!! json_encode($grafikTren->pluck('total')) !!};
    const trenSelesaiData = {!! json_encode($grafikTren->pluck('selesai')) !!};

    new Chart(trenCtx, {
        type: 'line',
        data: {
            labels: trenLabels,
            datasets: [
                {
                    label: 'Total Pengajuan',
                    data: trenTotalData,
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointBackgroundColor: 'rgb(16, 185, 129)',
                    pointRadius: 4,
                },
                {
                    label: 'Surat Selesai / Sah',
                    data: trenSelesaiData,
                    borderColor: 'rgb(14, 165, 233)',
                    backgroundColor: 'rgba(14, 165, 233, 0.05)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    borderDash: [4, 4],
                    pointBackgroundColor: 'rgb(14, 165, 233)',
                    pointRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // 1. Chart Dusun
    const dusunCtx = document.getElementById('dusunChart').getContext('2d');
    const dusunLabels = {!! json_encode($grafikDusun->pluck('nama')) !!};
    const dusunData = {!! json_encode($grafikDusun->pluck('total')) !!};

    new Chart(dusunCtx, {
        type: 'bar',
        data: {
            labels: dusunLabels,
            datasets: [{
                label: 'Jumlah Warga',
                data: dusunData,
                backgroundColor: 'rgba(5, 150, 105, 0.8)',
                borderColor: 'rgb(5, 150, 105)',
                borderWidth: 1,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // 2. Chart Pekerjaan
    const pekerjaanCtx = document.getElementById('pekerjaanChart').getContext('2d');
    const pekerjaanLabels = {!! json_encode($grafikPekerjaan->pluck('nama_pekerjaan')) !!};
    const pekerjaanData = {!! json_encode($grafikPekerjaan->pluck('penduduk_count')) !!};

    new Chart(pekerjaanCtx, {
        type: 'doughnut',
        data: {
            labels: pekerjaanLabels,
            datasets: [{
                data: pekerjaanData,
                backgroundColor: [
                    '#059669', // Emerald
                    '#0284c7', // Sky
                    '#d97706', // Amber
                    '#6366f1', // Indigo
                    '#ec4899', // Pink
                    '#84cc16', // Lime
                    '#64748b', // Slate
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        font: { size: 10 }
                    }
                }
            }
        }
    });
});
</script>
@endsection

