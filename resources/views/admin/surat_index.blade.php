@extends('layouts.admin')

@section('title', 'Manajemen Surat - Kelurahan Notoharjo')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen & Verifikasi Persuratan</h1>
            <p class="text-xs text-slate-500">Alur berjenjang: Kasi Pelayanan &rarr; Sekretaris Kelurahan &rarr; Lurah Notoharjo (Dilengkapi Pencarian AJAX)</p>
        </div>
        <div class="flex items-center space-x-2">
            <span id="surat-loading" class="hidden items-center space-x-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-semibold animate-pulse">
                <i class="fa-solid fa-circle-notch fa-spin"></i>
                <span>Memuat permohonan...</span>
            </span>
        </div>
    </div>

    <!-- Filter Status Tabs (AJAX Enabled) -->
    <div class="flex flex-wrap gap-2 text-xs font-bold" id="status-tab-group">
        <button type="button" data-status="" class="status-tab px-4 py-2 rounded-xl transition flex items-center space-x-1.5 {{ empty($status) ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Semua</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ empty($status) ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $statusCounts['semua'] ?? 0 }}</span>
        </button>
        <button type="button" data-status="menunggu_verifikasi" class="status-tab px-4 py-2 rounded-xl transition flex items-center space-x-1.5 {{ $status === 'menunggu_verifikasi' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Menunggu Kasi Pelayanan</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $status === 'menunggu_verifikasi' ? 'bg-amber-800 text-white' : 'bg-amber-100 text-amber-800' }}">{{ $statusCounts['menunggu_verifikasi'] ?? 0 }}</span>
        </button>
        <button type="button" data-status="diverifikasi_kasi" class="status-tab px-4 py-2 rounded-xl transition flex items-center space-x-1.5 {{ $status === 'diverifikasi_kasi' ? 'bg-sky-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Paraf Sekretaris</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $status === 'diverifikasi_kasi' ? 'bg-sky-800 text-white' : 'bg-sky-100 text-sky-800' }}">{{ $statusCounts['diverifikasi_kasi'] ?? 0 }}</span>
        </button>
        <button type="button" data-status="diparaf_sekretaris" class="status-tab px-4 py-2 rounded-xl transition flex items-center space-x-1.5 {{ $status === 'diparaf_sekretaris' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>TTD Lurah</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $status === 'diparaf_sekretaris' ? 'bg-indigo-800 text-white' : 'bg-indigo-100 text-indigo-800' }}">{{ $statusCounts['diparaf_sekretaris'] ?? 0 }}</span>
        </button>
        <button type="button" data-status="selesai" class="status-tab px-4 py-2 rounded-xl transition flex items-center space-x-1.5 {{ $status === 'selesai' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Selesai / Terbit</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $status === 'selesai' ? 'bg-emerald-800 text-white' : 'bg-emerald-100 text-emerald-800' }}">{{ $statusCounts['selesai'] ?? 0 }}</span>
        </button>
        <button type="button" data-status="ditolak" class="status-tab px-4 py-2 rounded-xl transition flex items-center space-x-1.5 {{ $status === 'ditolak' ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Ditolak</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $status === 'ditolak' ? 'bg-rose-800 text-white' : 'bg-rose-100 text-rose-800' }}">{{ $statusCounts['ditolak'] ?? 0 }}</span>
        </button>
    </div>

    <!-- Search & Advanced Filters Card (AJAX) -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200 shadow-sm space-y-4">
        <form id="filter-surat-form" action="{{ route('admin.surat.index') }}" method="GET" onsubmit="return false;" class="space-y-4">
            <input type="hidden" id="current-status" name="status" value="{{ $status }}">
            <input type="hidden" id="current-preset-tgl" name="preset_tgl" value="{{ $presetTgl ?? '' }}">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <!-- Search Box -->
                <div class="md:col-span-5 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="filter-surat-q" name="q" value="{{ $cari }}" placeholder="Cari Token QR, Nomor Surat, Nama Warga, atau NIK..."
                           class="w-full pl-11 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" autocomplete="off">
                    <button type="button" id="clear-surat-q" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 {{ empty($cari) ? 'hidden' : '' }}">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <!-- Jenis Surat Dropdown -->
                <div class="md:col-span-3">
                    <select id="filter-kode-surat" name="id_kode_surat" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="">Semua Jenis Surat</option>
                        @foreach($jenisSuratList as $kode)
                            <option value="{{ $kode->id_kode_surat }}" {{ (string)$kodeSuratId === (string)$kode->id_kode_surat ? 'selected' : '' }}>
                                {{ $kode->nama_surat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Urutkan / Sorting -->
                <div class="md:col-span-2">
                    <select id="filter-sort" name="sort" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="latest" {{ ($sort ?? '') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="urgent" {{ ($sort ?? '') === 'urgent' ? 'selected' : '' }}>Prioritas Tertunda</option>
                    </select>
                </div>

                <!-- Rentang Tanggal Mulai -->
                <div class="md:col-span-2 flex items-center space-x-1.5">
                    <input type="date" id="filter-tgl-mulai" name="tgl_mulai" value="{{ $tglMulai }}" class="w-full px-2 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500" title="Tanggal Mulai">
                    <span class="text-xs text-slate-400 font-bold">-</span>
                    <input type="date" id="filter-tgl-selesai" name="tgl_selesai" value="{{ $tglSelesai }}" class="w-full px-2 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500" title="Tanggal Akhir">
                </div>
            </div>

            <!-- Quick Date Preset Buttons & Reset -->
            <div class="flex flex-wrap items-center justify-between pt-1 gap-2 text-xs">
                <div class="flex items-center space-x-1.5">
                    <span class="text-[11px] text-slate-400 font-semibold mr-1">Filter Waktu:</span>
                    <button type="button" data-preset="" class="preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition {{ empty($presetTgl) && empty($tglMulai) ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Semua</button>
                    <button type="button" data-preset="hari_ini" class="preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition {{ ($presetTgl ?? '') === 'hari_ini' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Hari Ini</button>
                    <button type="button" data-preset="7_hari" class="preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition {{ ($presetTgl ?? '') === '7_hari' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">7 Hari</button>
                    <button type="button" data-preset="bulan_ini" class="preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition {{ ($presetTgl ?? '') === 'bulan_ini' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Bulan Ini</button>
                    <button type="button" data-preset="lama" class="preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition {{ ($presetTgl ?? '') === 'lama' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i>Tertunda > 2 Hari
                    </button>
                </div>
                <button type="button" id="reset-surat-filter-btn" class="text-slate-600 hover:text-rose-600 font-bold transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-rotate-left text-xs"></i>
                    <span>Setel Ulang Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Table Container (Updated via AJAX) -->
    <div id="surat-table-container" class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm transition-opacity duration-200">
        @include('admin.partials.surat_table', ['daftarSurat' => $daftarSurat])
    </div>
</div>

<!-- AJAX Real-Time Search & Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('filter-surat-q');
    const clearBtn = document.getElementById('clear-surat-q');
    const currentStatusInput = document.getElementById('current-status');
    const currentPresetInput = document.getElementById('current-preset-tgl');
    const statusTabs = document.querySelectorAll('.status-tab');
    const presetBtns = document.querySelectorAll('.preset-btn');
    const kodeSuratSelect = document.getElementById('filter-kode-surat');
    const sortSelect = document.getElementById('filter-sort');
    const tglMulaiInput = document.getElementById('filter-tgl-mulai');
    const tglSelesaiInput = document.getElementById('filter-tgl-selesai');
    const resetBtn = document.getElementById('reset-surat-filter-btn');
    const tableContainer = document.getElementById('surat-table-container');
    const loadingIndicator = document.getElementById('surat-loading');

    let debounceTimer;

    function buildQueryString(page = 1) {
        const params = new URLSearchParams();
        if (currentStatusInput.value) params.append('status', currentStatusInput.value);
        if (currentPresetInput.value) params.append('preset_tgl', currentPresetInput.value);
        if (searchInput.value.trim()) params.append('q', searchInput.value.trim());
        if (kodeSuratSelect.value) params.append('id_kode_surat', kodeSuratSelect.value);
        if (sortSelect.value) params.append('sort', sortSelect.value);
        if (tglMulaiInput.value) params.append('tgl_mulai', tglMulaiInput.value);
        if (tglSelesaiInput.value) params.append('tgl_selesai', tglSelesaiInput.value);
        if (page > 1) params.append('page', page);
        return params.toString();
    }

    function fetchData(page = 1) {
        const queryString = buildQueryString(page);
        const url = `{{ route('admin.surat.index') }}?${queryString}`;

        window.history.replaceState({}, '', url);

        loadingIndicator.classList.remove('hidden');
        loadingIndicator.classList.add('inline-flex');
        tableContainer.classList.add('opacity-50');

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(html => {
            tableContainer.innerHTML = html;
            tableContainer.classList.remove('opacity-50');
            loadingIndicator.classList.add('hidden');
            loadingIndicator.classList.remove('inline-flex');
            attachPaginationListeners();
        })
        .catch(err => {
            console.error('AJAX fetch error:', err);
            tableContainer.classList.remove('opacity-50');
            loadingIndicator.classList.add('hidden');
            loadingIndicator.classList.remove('inline-flex');
        });
    }

    function attachPaginationListeners() {
        const paginationLinks = tableContainer.querySelectorAll('.ajax-pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page') || 1;
                fetchData(page);
            });
        });
    }

    // Status tab click handling
    statusTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const selectedStatus = this.getAttribute('data-status');
            currentStatusInput.value = selectedStatus;

            statusTabs.forEach(t => {
                t.className = 'status-tab px-4 py-2 rounded-xl transition bg-white text-slate-600 hover:bg-slate-50 border border-slate-200';
            });

            if (selectedStatus === 'menunggu_verifikasi') {
                this.className = 'status-tab px-4 py-2 rounded-xl transition bg-amber-600 text-white font-bold';
            } else if (selectedStatus === 'diverifikasi_kasi') {
                this.className = 'status-tab px-4 py-2 rounded-xl transition bg-sky-600 text-white font-bold';
            } else if (selectedStatus === 'diparaf_sekretaris') {
                this.className = 'status-tab px-4 py-2 rounded-xl transition bg-indigo-600 text-white font-bold';
            } else if (selectedStatus === 'selesai') {
                this.className = 'status-tab px-4 py-2 rounded-xl transition bg-emerald-600 text-white font-bold';
            } else if (selectedStatus === 'ditolak') {
                this.className = 'status-tab px-4 py-2 rounded-xl transition bg-rose-600 text-white font-bold';
            } else {
                this.className = 'status-tab px-4 py-2 rounded-xl transition bg-slate-900 text-white font-bold';
            }

            fetchData(1);
        });
    });

    // Debounced search input
    searchInput.addEventListener('input', function () {
        if (this.value.trim()) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchData(1);
        }, 300);
    });

    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        clearBtn.classList.add('hidden');
        fetchData(1);
    });

    // Dropdowns & Date inputs trigger AJAX
    [kodeSuratSelect, sortSelect, tglMulaiInput, tglSelesaiInput].forEach(element => {
        element.addEventListener('change', () => {
            currentPresetInput.value = '';
            presetBtns.forEach(b => b.className = 'preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition bg-slate-100 text-slate-600 hover:bg-slate-200');
            fetchData(1);
        });
    });

    // Preset buttons handling
    presetBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const preset = this.getAttribute('data-preset');
            currentPresetInput.value = preset;
            tglMulaiInput.value = '';
            tglSelesaiInput.value = '';

            presetBtns.forEach(b => b.className = 'preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition bg-slate-100 text-slate-600 hover:bg-slate-200');
            if (preset === 'lama') {
                this.className = 'preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition bg-amber-600 text-white';
            } else if (preset) {
                this.className = 'preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition bg-emerald-600 text-white';
            } else {
                this.className = 'preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition bg-slate-900 text-white';
            }

            fetchData(1);
        });
    });

    // Reset button
    resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        clearBtn.classList.add('hidden');
        currentStatusInput.value = '';
        currentPresetInput.value = '';
        kodeSuratSelect.value = '';
        sortSelect.value = 'latest';
        tglMulaiInput.value = '';
        tglSelesaiInput.value = '';

        presetBtns.forEach(b => b.className = 'preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition bg-slate-100 text-slate-600 hover:bg-slate-200');
        presetBtns[0].className = 'preset-btn px-2.5 py-1 rounded-lg text-[11px] font-bold transition bg-slate-900 text-white';

        statusTabs.forEach(t => {
            t.className = 'status-tab px-4 py-2 rounded-xl transition bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 flex items-center space-x-1.5';
        });
        statusTabs[0].className = 'status-tab px-4 py-2 rounded-xl transition bg-slate-900 text-white font-bold flex items-center space-x-1.5';

        fetchData(1);
    });

    attachPaginationListeners();
});
</script>
@endsection
