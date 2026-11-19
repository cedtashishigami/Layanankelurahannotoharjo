<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\KartuKeluarga;
use App\Models\KodeSurat;
use App\Models\LayananPengaduan;
use App\Models\Penduduk;
use App\Models\PermohonanSurat;
use App\Models\PotensiKelurahan;
use App\Models\TransparansiAnggaran;
use App\Models\WilayahDusun;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $beritaTerbaru = Berita::where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        $agendaMendatang = Agenda::where('tanggal_mulai', '>=', now()->startOfDay())
            ->orderBy('tanggal_mulai')
            ->take(3)
            ->get();

        $potensiUnggulan = PotensiKelurahan::with('dusun')
            ->take(3)
            ->get();

        $transparansiList = TransparansiAnggaran::where('tahun_anggaran', 2026)->get();

        $totalPenduduk = max(3318, Penduduk::where('status_keberadaan', 'Aktif')->count());
        $totalKK = max(984, KartuKeluarga::count());

        $statistik = [
            'total_penduduk' => $totalPenduduk,
            'total_kk' => $totalKK,
            'total_dusun' => WilayahDusun::count() ?: 3,
            'surat_selesai' => PermohonanSurat::where('status', 'selesai')->count(),
        ];

        $daftarLayanan = KodeSurat::with('syaratSurat')->get();

        return view('home.index', compact(
            'beritaTerbaru',
            'agendaMendatang',
            'potensiUnggulan',
            'transparansiList',
            'statistik',
            'daftarLayanan'
        ));
    }

    public function profil(): View
    {
        $dusunList = WilayahDusun::with('wilayahRt')->get();

        return view('home.profil', compact('dusunList'));
    }

    public function berita(): View
    {
        $berita = Berita::where('status', 'published')
            ->latest()
            ->paginate(6);

        return view('home.berita', compact('berita'));
    }

    public function beritaDetail(string $slug): View
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        $berita->increment('views');

        $beritaLainnya = Berita::where('status', 'published')
            ->where('id_berita', '!=', $berita->id_berita)
            ->latest()
            ->take(4)
            ->get();

        return view('home.berita_detail', compact('berita', 'beritaLainnya'));
    }

    public function potensi(): View
    {
        $potensi = PotensiKelurahan::with('dusun')->paginate(6);

        return view('home.potensi', compact('potensi'));
    }

    public function transparansi(): View
    {
        $anggaran = TransparansiAnggaran::orderBy('tahun_anggaran', 'desc')
            ->get()
            ->groupBy('tahun_anggaran');

        return view('home.transparansi', compact('anggaran'));
    }

    public function galeri(): View
    {
        $galeri = Galeri::latest()->paginate(9);

        return view('home.galeri', compact('galeri'));
    }

    public function agenda(Request $request): View
    {
        $filter = $request->query('status', 'semua');
        $cari = $request->query('q');

        $query = Agenda::with('petugas');

        if ($filter === 'mendatang') {
            $query->where('tanggal_mulai', '>=', now()->startOfDay());
        } elseif ($filter === 'selesai') {
            $query->where('tanggal_mulai', '<', now()->startOfDay());
        }

        if ($cari) {
            $query->where(function ($q) use ($cari): void {
                $q->where('nama_kegiatan', 'like', "%{$cari}%")
                    ->orWhere('lokasi', 'like', "%{$cari}%")
                    ->orWhere('penyelenggara', 'like', "%{$cari}%");
            });
        }

        $agendaList = $query->orderBy('tanggal_mulai', $filter === 'selesai' ? 'desc' : 'asc')
            ->paginate(6)
            ->withQueryString();

        $totalMendatang = Agenda::where('tanggal_mulai', '>=', now()->startOfDay())->count();
        $totalSelesai = Agenda::where('tanggal_mulai', '<', now()->startOfDay())->count();

        return view('home.agenda', compact('agendaList', 'filter', 'cari', 'totalMendatang', 'totalSelesai'));
    }

    public function lacakSurat(Request $request): View
    {
        $query = $request->input('q');
        $hasil = null;

        if ($query) {
            $hasil = PermohonanSurat::with(['pemohon', 'penduduk', 'kodeSurat', 'riwayatStatus'])
                ->where('token_qr', $query)
                ->orWhere('nomor_surat', $query)
                ->orWhereHas('penduduk', function ($q) use ($query): void {
                    $q->where('nik', $query);
                })
                ->latest()
                ->first();
        }

        return view('home.lacak_surat', compact('hasil', 'query'));
    }

    public function pengaduan(): View
    {
        $pengaduanPublik = LayananPengaduan::with(['pelapor', 'dusun'])
            ->latest()
            ->take(10)
            ->get();

        $dusunList = WilayahDusun::all();

        return view('home.pengaduan', compact('pengaduanPublik', 'dusunList'));
    }
}
