@extends('layouts.admin')

@section('title', 'Data Kependudukan - Kelurahan Notoharjo')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Data Induk Kependudukan</h1>
            <p class="text-xs text-slate-500">Master database seluruh warga terdaftar di Kelurahan Notoharjo dengan pencarian & filter instan (AJAX)</p>
        </div>
        <div class="flex items-center space-x-2">
            <span id="loading-indicator" class="hidden items-center space-x-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-semibold animate-pulse">
                <i class="fa-solid fa-circle-notch fa-spin"></i>
                <span>Menyinkronkan data...</span>
            </span>
        </div>
    </div>

    <!-- Search & Filter Controls (AJAX Enabled) -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200 shadow-sm space-y-4">
        <form id="filter-kependudukan-form" action="{{ route('admin.kependudukan.index') }}" method="GET" onsubmit="return false;" class="space-y-4">
            <!-- Row 1: Search Input -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" id="filter-q" name="q" value="{{ $cari }}" placeholder="Ketik Nama Lengkap, NIK KTP, atau Nomor KK (Pencarian Instan Otomatis)..."
                       class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" autocomplete="off">
                <button type="button" id="clear-search-btn" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 {{ empty($cari) ? 'hidden' : '' }}">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Row 2: Filter Dropdowns -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Filter Wilayah Dusun -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Wilayah Dusun</label>
                    <select id="filter-dusun" name="id_dusun" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="">Semua Dusun (I, II, III)</option>
                        @foreach($dusunList as $dusun)
                            <option value="{{ $dusun->id_dusun }}" {{ (string)$dusunId === (string)$dusun->id_dusun ? 'selected' : '' }}>
                                {{ $dusun->nama_dusun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Jenis Kelamin -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
                    <select id="filter-gender" name="jenis_kelamin" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="">Semua (Laki & Perempuan)</option>
                        <option value="L" {{ $jenisKelamin === 'L' ? 'selected' : '' }}>Laki-Laki (L)</option>
                        <option value="P" {{ $jenisKelamin === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <!-- Filter Pekerjaan -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Mata Pencaharian</label>
                    <select id="filter-pekerjaan" name="id_pekerjaan" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="">Semua Pekerjaan</option>
                        @foreach($pekerjaanList as $pek)
                            <option value="{{ $pek->id_pekerjaan }}" {{ (string)$pekerjaanId === (string)$pek->id_pekerjaan ? 'selected' : '' }}>
                                {{ $pek->nama_pekerjaan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status Keberadaan -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Status Keberadaan</label>
                    <select id="filter-status" name="status" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="Aktif" {{ $status === 'Aktif' ? 'selected' : '' }}>Warga Aktif</option>
                        <option value="Meninggal" {{ $status === 'Meninggal' ? 'selected' : '' }}>Meninggal Dunia</option>
                        <option value="Pindah" {{ $status === 'Pindah' ? 'selected' : '' }}>Pindah Keluar</option>
                        <option value="Semua" {{ $status === 'Semua' ? 'selected' : '' }}>Semua Riwayat Status</option>
                    </select>
                </div>
            </div>

            <!-- Filter Reset Action -->
            <div class="flex items-center justify-between pt-1 text-xs">
                <span class="text-slate-400 text-[11px]">
                    <i class="fa-solid fa-bolt text-amber-500 mr-1"></i>Pencarian otomatis diperbarui seketika (live AJAX)
                </span>
                <button type="button" id="reset-filter-btn" class="text-slate-600 hover:text-rose-600 font-bold transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-rotate-left text-xs"></i>
                    <span>Setel Ulang Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Table Container (Dynamically Updated via AJAX) -->
    <div id="kependudukan-table-container" class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm transition-opacity duration-200">
        @include('admin.partials.kependudukan_table', ['daftarPenduduk' => $daftarPenduduk])
    </div>
</div>

<!-- AJAX Real-Time Search & Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('filter-q');
    const clearBtn = document.getElementById('clear-search-btn');
    const dusunSelect = document.getElementById('filter-dusun');
    const genderSelect = document.getElementById('filter-gender');
    const pekerjaanSelect = document.getElementById('filter-pekerjaan');
    const statusSelect = document.getElementById('filter-status');
    const resetBtn = document.getElementById('reset-filter-btn');
    const tableContainer = document.getElementById('kependudukan-table-container');
    const loadingIndicator = document.getElementById('loading-indicator');

    let debounceTimer;

    function buildQueryString(page = 1) {
        const params = new URLSearchParams();
        if (searchInput.value.trim()) params.append('q', searchInput.value.trim());
        if (dusunSelect.value) params.append('id_dusun', dusunSelect.value);
        if (genderSelect.value) params.append('jenis_kelamin', genderSelect.value);
        if (pekerjaanSelect.value) params.append('id_pekerjaan', pekerjaanSelect.value);
        if (statusSelect.value) params.append('status', statusSelect.value);
        if (page > 1) params.append('page', page);
        return params.toString();
    }

    function fetchData(page = 1) {
        const queryString = buildQueryString(page);
        const url = `{{ route('admin.kependudukan.index') }}?${queryString}`;

        // Update browser URL without reloading
        window.history.replaceState({}, '', url);

        // Show loading state
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

    // Search input with debounce (300ms)
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

    // Clear search button
    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        clearBtn.classList.add('hidden');
        fetchData(1);
    });

    // Dropdowns trigger immediate AJAX
    [dusunSelect, genderSelect, pekerjaanSelect, statusSelect].forEach(select => {
        select.addEventListener('change', () => fetchData(1));
    });

    // Reset filter button
    resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        clearBtn.classList.add('hidden');
        dusunSelect.value = '';
        genderSelect.value = '';
        pekerjaanSelect.value = '';
        statusSelect.value = 'Aktif';
        fetchData(1);
    });

    // Initial pagination listener attachment
    attachPaginationListeners();
});
</script>
@endsection
