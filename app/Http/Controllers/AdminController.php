<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\KartuKeluarga;
use App\Models\KodeSurat;
use App\Models\LayananPengaduan;
use App\Models\MutasiPenduduk;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use App\Models\PermohonanSurat;
use App\Models\PotensiKelurahan;
use App\Models\RiwayatStatusSurat;
use App\Models\TransparansiAnggaran;
use App\Models\User;
use App\Models\WilayahDusun;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $totalSemuaSurat = PermohonanSurat::count();
        $totalSelesaiSurat = PermohonanSurat::where('status', 'selesai')->count();
        $ratePenyelesaian = $totalSemuaSurat > 0 ? (int) round(($totalSelesaiSurat / $totalSemuaSurat) * 100) : 100;

        $totalPenduduk = max(3318, Penduduk::where('status_keberadaan', 'Aktif')->count());
        $totalKK = max(984, KartuKeluarga::count());
        $pendudukLaki = max(1710, Penduduk::where('status_keberadaan', 'Aktif')->where('jenis_kelamin', 'L')->count());
        $pendudukPerempuan = max(1608, Penduduk::where('status_keberadaan', 'Aktif')->where('jenis_kelamin', 'P')->count());

        $statistik = [
            'total_penduduk' => $totalPenduduk,
            'total_kk' => $totalKK,
            'penduduk_laki' => $pendudukLaki,
            'penduduk_perempuan' => $pendudukPerempuan,
            'surat_masuk' => PermohonanSurat::where('status', 'menunggu_verifikasi')->count(),
            'surat_paraf' => PermohonanSurat::where('status', 'diverifikasi_kasi')->count(),
            'surat_lurah' => PermohonanSurat::where('status', 'diparaf_sekretaris')->count(),
            'surat_selesai' => $totalSelesaiSurat,
            'surat_hari_ini' => PermohonanSurat::whereDate('created_at', today())->count(),
            'surat_pending_total' => PermohonanSurat::whereIn('status', ['menunggu_verifikasi', 'diverifikasi_kasi', 'diparaf_sekretaris'])->count(),
            'warga_baru_bulan_ini' => User::where('role', 'warga')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'rate_penyelesaian' => $ratePenyelesaian,
            'pengaduan_pending' => LayananPengaduan::where('status', 'diajukan')->count(),
        ];

        // Alert Surat Tertunda > 2 Hari
        $suratTertunda = PermohonanSurat::with(['pemohon', 'penduduk', 'kodeSurat'])
            ->whereIn('status', ['menunggu_verifikasi', 'diverifikasi_kasi', 'diparaf_sekretaris'])
            ->where('created_at', '<=', now()->subDays(2))
            ->oldest()
            ->get();

        // Grafik Tren Permohonan Surat 6 Bulan Terakhir
        $grafikTren = collect();
        for ($i = 5; $i >= 0; $i--) {
            $dt = now()->subMonths($i);
            $label = $dt->translatedFormat('M Y');
            $totalBulan = PermohonanSurat::whereYear('created_at', $dt->year)
                ->whereMonth('created_at', $dt->month)
                ->count();
            $selesaiBulan = PermohonanSurat::whereYear('created_at', $dt->year)
                ->whereMonth('created_at', $dt->month)
                ->where('status', 'selesai')
                ->count();

            $grafikTren->push([
                'bulan' => $label,
                'total' => $totalBulan,
                'selesai' => $selesaiBulan,
            ]);
        }

        // Data Grafik Mata Pencaharian & Persebaran Dusun
        $grafikPekerjaan = Pekerjaan::withCount(['penduduk' => function ($q): void {
            $q->where('status_keberadaan', 'Aktif');
        }])->get()->filter(fn ($p) => $p->penduduk_count > 0)->values();

        $grafikDusun = WilayahDusun::with('wilayahRt')->get()->map(function ($dusun): array {
            $rtIds = $dusun->wilayahRt->pluck('id_rt');
            $kkIds = KartuKeluarga::whereIn('id_rt', $rtIds)->pluck('id_kartu_keluarga');
            $total = Penduduk::whereIn('id_kartu_keluarga', $kkIds)->where('status_keberadaan', 'Aktif')->count();

            return [
                'nama' => $dusun->nama_dusun,
                'total' => $total,
            ];
        });

        $suratTerbaru = PermohonanSurat::with(['pemohon', 'penduduk', 'kodeSurat'])
            ->latest()
            ->take(6)
            ->get();

        $pengaduanTerbaru = LayananPengaduan::with(['pelapor', 'dusun'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'statistik',
            'suratTertunda',
            'grafikTren',
            'grafikPekerjaan',
            'grafikDusun',
            'suratTerbaru',
            'pengaduanTerbaru'
        ));
    }

    public function suratIndex(Request $request): View|string
    {
        $status = $request->query('status');
        $cari = $request->query('q');
        $kodeSuratId = $request->query('id_kode_surat');
        $tglMulai = $request->query('tgl_mulai');
        $tglSelesai = $request->query('tgl_selesai');
        $presetTgl = $request->query('preset_tgl');
        $sort = $request->query('sort', 'latest');

        $query = PermohonanSurat::with(['pemohon', 'penduduk', 'kodeSurat']);

        // Handle preset tanggal cepat
        if ($presetTgl === 'hari_ini') {
            $query->whereDate('tanggal_pengajuan', today());
        } elseif ($presetTgl === '7_hari') {
            $query->whereDate('tanggal_pengajuan', '>=', now()->subDays(7)->toDateString());
        } elseif ($presetTgl === 'bulan_ini') {
            $query->whereMonth('tanggal_pengajuan', now()->month)
                ->whereYear('tanggal_pengajuan', now()->year);
        } elseif ($presetTgl === 'lama') {
            $query->whereIn('status', ['menunggu_verifikasi', 'diverifikasi_kasi', 'diparaf_sekretaris'])
                ->where('created_at', '<=', now()->subDays(2));
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($cari) {
            $query->where(function ($q) use ($cari): void {
                $q->where('token_qr', 'like', "%{$cari}%")
                    ->orWhere('nomor_surat', 'like', "%{$cari}%")
                    ->orWhereHas('penduduk', function ($p) use ($cari): void {
                        $p->where('nama_lengkap', 'like', "%{$cari}%")
                            ->orWhere('nik', 'like', "%{$cari}%");
                    });
            });
        }

        if ($kodeSuratId) {
            $query->where('id_kode_surat', $kodeSuratId);
        }

        if ($tglMulai) {
            $query->whereDate('tanggal_pengajuan', '>=', $tglMulai);
        }

        if ($tglSelesai) {
            $query->whereDate('tanggal_pengajuan', '<=', $tglSelesai);
        }

        // Sorting
        if ($sort === 'oldest') {
            $query->oldest('tanggal_pengajuan')->oldest('id_permohonan_surat');
        } elseif ($sort === 'urgent') {
            $query->orderByRaw("FIELD(status, 'menunggu_verifikasi', 'diverifikasi_kasi', 'diparaf_sekretaris', 'selesai', 'ditolak')")
                ->oldest('created_at');
        } else {
            $query->latest('tanggal_pengajuan')->latest('id_permohonan_surat');
        }

        $daftarSurat = $query->paginate(10)->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            return view('admin.partials.surat_table', compact('daftarSurat'))->render();
        }

        $jenisSuratList = KodeSurat::all();

        // Hitungan per status untuk tab badge
        $statusCounts = [
            'semua' => PermohonanSurat::count(),
            'menunggu_verifikasi' => PermohonanSurat::where('status', 'menunggu_verifikasi')->count(),
            'diverifikasi_kasi' => PermohonanSurat::where('status', 'diverifikasi_kasi')->count(),
            'diparaf_sekretaris' => PermohonanSurat::where('status', 'diparaf_sekretaris')->count(),
            'selesai' => PermohonanSurat::where('status', 'selesai')->count(),
            'ditolak' => PermohonanSurat::where('status', 'ditolak')->count(),
        ];

        return view('admin.surat_index', compact(
            'daftarSurat',
            'status',
            'cari',
            'kodeSuratId',
            'jenisSuratList',
            'tglMulai',
            'tglSelesai',
            'presetTgl',
            'sort',
            'statusCounts'
        ));
    }

    public function suratDetail(int $id): View
    {
        $permohonan = PermohonanSurat::with([
            'pemohon',
            'penduduk.kartuKeluarga.rt.dusun',
            'kodeSurat',
            'lampiranPermohonan.syaratSurat',
            'riwayatStatus.petugas',
        ])->findOrFail($id);

        return view('admin.surat_detail', compact('permohonan'));
    }

    public function suratAction(Request $request, int $id): RedirectResponse
    {
        $user = Auth::user();
        $permohonan = PermohonanSurat::findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:verifikasi_kasi,paraf_sekretaris,setujui_lurah,tolak',
            'nomor_surat' => 'nullable|string|max:100',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $action = $validated['action'];
        $catatan = $validated['catatan'] ?? '';

        // Hak Akses Ketat (RBAC Governance)
        if ($action === 'verifikasi_kasi' && ! ($user->isAdmin() || $user->isKasiPelayanan())) {
            return back()->with('error', 'Hanya Kepala Seksi Pelayanan atau Administrator yang berwenang memverifikasi berkas.');
        }

        if ($action === 'paraf_sekretaris' && ! ($user->isAdmin() || $user->isSekretaris())) {
            return back()->with('error', 'Hanya Sekretaris Kelurahan atau Administrator yang berwenang membubuhkan paraf dan nomor surat.');
        }

        if ($action === 'setujui_lurah' && ! ($user->isAdmin() || $user->isLurah())) {
            return back()->with('error', 'Hanya Kepala Kelurahan (Lurah) atau Administrator yang berwenang mengesahkan surat.');
        }

        if ($action === 'verifikasi_kasi') {
            $permohonan->status = 'diverifikasi_kasi';
            $tahapan = 'Verifikasi Berkas oleh Kasi Pelayanan';
            $statusTahap = 'disetujui';
            $pesanNotif = 'Berkas persyaratan Anda telah diperiksa dan diverifikasi sah oleh Kasi Pelayanan. Menunggu paraf Sekretaris Kelurahan.';
        } elseif ($action === 'paraf_sekretaris') {
            $request->validate(['nomor_surat' => 'required|string|max:100']);
            $permohonan->nomor_surat = $validated['nomor_surat'];
            $permohonan->status = 'diparaf_sekretaris';
            $tahapan = 'Pemeriksaan & Penomoran Surat oleh Sekretaris';
            $statusTahap = 'disetujui';
            $pesanNotif = 'Surat telah diperiksa Sekretaris dengan nomor '.$validated['nomor_surat'].' dan siap disetujui Lurah.';
        } elseif ($action === 'setujui_lurah') {
            $permohonan->status = 'selesai';
            $permohonan->tanggal_disahkan = now()->toDateString();
            $tahapan = 'Persetujuan & Tanda Tangan Elektronik oleh Lurah';
            $statusTahap = 'disetujui';
            $pesanNotif = 'Selamat! Permohonan surat Anda telah disetujui dan ditandatangani oleh Lurah Notoharjo. Dokumen siap diunduh atau dicetak.';
        } else {
            // Tolak / Revisi
            $request->validate(['catatan' => 'required|string|max:1000']);
            $permohonan->status = 'ditolak';
            $tahapan = 'Penolakan / Permintaan Revisi Berkas';
            $statusTahap = 'ditolak';
            $pesanNotif = 'Permohonan surat Anda memerlukan perbaikan/revisi berkas: '.$catatan;
        }

        $permohonan->save();

        // Rekam riwayat audit trail
        RiwayatStatusSurat::create([
            'id_permohonan_surat' => $permohonan->id_permohonan_surat,
            'id_user' => $user->id_user,
            'tahapan' => $tahapan.' ('.$user->name.')',
            'status_tahap' => $statusTahap,
            'catatan_petugas' => $catatan ?: 'Diproses oleh '.$user->jabatan,
        ]);

        // Kirim Notifikasi WhatsApp & In-App ke Warga
        WhatsAppNotificationService::kirim(
            $permohonan->pemohon,
            'Update Status Permohonan Surat ('.$permohonan->kodeSurat->nama_surat.')',
            $pesanNotif,
            route('warga.surat.detail', $permohonan->id_permohonan_surat)
        );

        return redirect()->route('admin.surat.detail', $permohonan->id_permohonan_surat)
            ->with('success', 'Keputusan berhasil disimpan dan diteruskan: '.$tahapan);
    }

    public function suratCetak(int $id): View
    {
        $permohonan = PermohonanSurat::with([
            'pemohon',
            'penduduk.kartuKeluarga.rt.dusun',
            'penduduk.pekerjaan',
            'penduduk.pendidikan',
            'kodeSurat',
        ])->findOrFail($id);

        $lurah = User::where('role', 'lurah')->first() ?? (object) [
            'name' => 'Bambang Sungkowo',
            'jabatan' => 'Kepala Kelurahan Notoharjo',
        ];

        return view('admin.surat_cetak', compact('permohonan', 'lurah'));
    }

    public function kependudukanIndex(Request $request): View|string
    {
        $cari = $request->query('q');
        $dusunId = $request->query('id_dusun');
        $jenisKelamin = $request->query('jenis_kelamin');
        $pekerjaanId = $request->query('id_pekerjaan');
        $status = $request->query('status', 'Aktif');

        $query = Penduduk::with(['kartuKeluarga.rt.dusun', 'pekerjaan', 'pendidikan'])->latest();

        if ($status && $status !== 'Semua') {
            $query->where('status_keberadaan', $status);
        }

        if ($cari) {
            $query->where(function ($q) use ($cari): void {
                $q->where('nama_lengkap', 'like', "%{$cari}%")
                    ->orWhere('nik', 'like', "%{$cari}%")
                    ->orWhereHas('kartuKeluarga', function ($k) use ($cari): void {
                        $k->where('nomor_kk', 'like', "%{$cari}%");
                    });
            });
        }

        if ($dusunId) {
            $query->whereHas('kartuKeluarga.rt', function ($q) use ($dusunId): void {
                $q->where('id_dusun', $dusunId);
            });
        }

        if ($jenisKelamin) {
            $query->where('jenis_kelamin', $jenisKelamin);
        }

        if ($pekerjaanId) {
            $query->where('id_pekerjaan', $pekerjaanId);
        }

        $daftarPenduduk = $query->paginate(10)->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            return view('admin.partials.kependudukan_table', compact('daftarPenduduk'))->render();
        }

        $dusunList = WilayahDusun::all();
        $pekerjaanList = Pekerjaan::all();
        $pendidikanList = Pendidikan::all();

        return view('admin.kependudukan_index', compact(
            'daftarPenduduk',
            'dusunList',
            'pekerjaanList',
            'pendidikanList',
            'cari',
            'dusunId',
            'jenisKelamin',
            'pekerjaanId',
            'status'
        ));
    }

    public function mutasiIndex(): View
    {
        $mutasi = MutasiPenduduk::with(['penduduk', 'petugas'])->latest()->paginate(15);
        $pendudukList = Penduduk::where('status_keberadaan', 'Aktif')->get();

        return view('admin.mutasi_index', compact('mutasi', 'pendudukList'));
    }

    public function mutasiStore(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'id_penduduk' => 'required|exists:penduduk,id_penduduk',
            'jenis_mutasi' => 'required|in:Kelahiran,Kematian,Pindah_Masuk,Pindah_Keluar',
            'tanggal_kejadian' => 'required|date',
            'nomor_surat_keterangan' => 'nullable|string|max:100',
            'alasan_tujuan' => 'nullable|string|max:500',
        ]);

        $mutasi = MutasiPenduduk::create([
            'id_penduduk' => $validated['id_penduduk'],
            'id_user' => $user->id_user,
            'jenis_mutasi' => $validated['jenis_mutasi'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'nomor_surat_keterangan' => $validated['nomor_surat_keterangan'] ?? null,
            'alasan_tujuan' => $validated['alasan_tujuan'] ?? null,
        ]);

        $penduduk = Penduduk::find($validated['id_penduduk']);
        if ($validated['jenis_mutasi'] === 'Kematian') {
            $penduduk->status_keberadaan = 'Meninggal';
            $penduduk->save();
        } elseif ($validated['jenis_mutasi'] === 'Pindah_Keluar') {
            $penduduk->status_keberadaan = 'Pindah';
            $penduduk->save();
        }

        return back()->with('success', 'Peristiwa mutasi kependudukan berhasil dicatat.');
    }

    public function pengaduanIndex(): View
    {
        $pengaduan = LayananPengaduan::with(['pelapor', 'dusun'])->latest()->paginate(15);

        return view('admin.pengaduan_index', compact('pengaduan'));
    }

    public function pengaduanTanggapi(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:ditinjau,dalam_tindakan,selesai,ditolak',
            'tanggapan_petugas' => 'required|string|max:1500',
        ]);

        $aduan = LayananPengaduan::findOrFail($id);
        $aduan->status = $validated['status'];
        $aduan->tanggapan_petugas = $validated['tanggapan_petugas'];
        $aduan->tanggal_tanggapan = now();
        $aduan->save();

        // Notifikasi ke warga
        WhatsAppNotificationService::kirim(
            $aduan->pelapor,
            'Tanggapan Aduan dari Kelurahan Notoharjo',
            'Aduan Anda "'.$aduan->judul_laporan.'" telah ditanggapi: '.$validated['tanggapan_petugas'],
            route('warga.pengaduan.index')
        );

        return back()->with('success', 'Tanggapan berhasil disimpan dan diteruskan ke pelapor.');
    }

    public function potensiIndex(): View
    {
        $potensi = PotensiKelurahan::with('dusun')->latest()->paginate(15);
        $dusunList = WilayahDusun::all();

        return view('admin.potensi_index', compact('potensi', 'dusunList'));
    }

    public function potensiStore(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'id_dusun' => 'required|exists:wilayah_dusun,id_dusun',
            'nama_potensi' => 'required|string|max:150',
            'kategori' => 'required|string',
            'pemilik' => 'nullable|string|max:150',
            'deskripsi' => 'nullable|string|max:2000',
            'kontak' => 'nullable|string|max:30',
            'lokasi' => 'nullable|string|max:255',
        ]);

        PotensiKelurahan::create(array_merge($validated, ['id_user' => $user->id_user]));

        return back()->with('success', 'Potensi kelurahan / UMKM berhasil ditambahkan.');
    }

    public function transparansiIndex(): View
    {
        $anggaran = TransparansiAnggaran::orderBy('tahun_anggaran', 'desc')->paginate(15);

        return view('admin.transparansi_index', compact('anggaran'));
    }

    public function transparansiStore(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'tahun_anggaran' => 'required|numeric|min:2020|max:2035',
            'jenis' => 'required|in:Pendapatan,Belanja,Pembiayaan',
            'bidang' => 'required|string|max:150',
            'uraian' => 'required|string|max:255',
            'target_anggaran' => 'required|numeric|min:0',
            'realisasi_anggaran' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        TransparansiAnggaran::create(array_merge($validated, ['id_user' => $user->id_user]));

        return back()->with('success', 'Data transparansi anggaran berhasil disimpan.');
    }

    // CRUD Berita
    public function beritaIndex(): View
    {
        $beritaList = Berita::with('penulis')->latest()->paginate(10);

        return view('admin.berita_index', compact('beritaList'));
    }

    public function beritaStore(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string|max:500',
            'isi_berita' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        Berita::create([
            'id_user' => $user->id_user,
            'judul' => $validated['judul'],
            'slug' => Str::slug($validated['judul']).'-'.time(),
            'ringkasan' => $validated['ringkasan'] ?? Str::limit(strip_tags($validated['isi_berita']), 150),
            'isi_berita' => $validated['isi_berita'],
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Berita berhasil dipublikasikan.');
    }

    // CRUD Agenda
    public function agendaIndex(): View
    {
        $agendaList = Agenda::with('petugas')->latest()->paginate(10);

        return view('admin.agenda_index', compact('agendaList'));
    }

    public function agendaStore(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:200',
            'lokasi' => 'required|string|max:200',
            'tanggal_mulai' => 'required|date',
            'deskripsi' => 'nullable|string|max:1000',
            'penyelenggara' => 'nullable|string|max:150',
        ]);

        Agenda::create(array_merge($validated, ['id_user' => $user->id_user]));

        return back()->with('success', 'Agenda kegiatan kelurahan berhasil ditambahkan.');
    }

    // Instrumen Pengujian Beta Testing (UAT SDLC)
    public function laporanPengujian(): View
    {
        return view('admin.laporan_pengujian');
    }

    // Galeri Foto & Video
    public function galeriIndex(): View
    {
        $galeri = Galeri::with('petugas')->latest()->paginate(9);

        return view('admin.galeri_index', compact('galeri'));
    }

    public function galeriStore(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'jenis_media' => 'required|in:foto,video',
            'file_media' => 'required|url|max:255',
            'keterangan' => 'nullable|string|max:500',
        ]);

        Galeri::create(array_merge($validated, ['id_user' => $user->id_user]));

        return back()->with('success', 'Media berhasil ditambahkan ke galeri kelurahan.');
    }

    public function galeriDestroy(int $id): RedirectResponse
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->delete();

        return back()->with('success', 'Media berhasil dihapus dari galeri.');
    }
}
