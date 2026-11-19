<?php

namespace App\Http\Controllers;

use App\Models\KodeSurat;
use App\Models\LampiranPermohonan;
use App\Models\LayananPengaduan;
use App\Models\Notifikasi;
use App\Models\Penduduk;
use App\Models\PermohonanSurat;
use App\Models\RiwayatStatusSurat;
use App\Models\WilayahDusun;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WargaController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $penduduk = $user->penduduk;

        // Ambil anggota keluarga dalam 1 KK
        $anggotaKeluarga = collect();
        if ($penduduk && $penduduk->id_kartu_keluarga) {
            $anggotaKeluarga = Penduduk::where('id_kartu_keluarga', $penduduk->id_kartu_keluarga)->get();
        }

        $suratTerakhir = PermohonanSurat::where('id_user', $user->id_user)
            ->with(['kodeSurat', 'penduduk'])
            ->latest()
            ->take(5)
            ->get();

        $notifikasi = Notifikasi::where('id_user', $user->id_user)
            ->latest()
            ->take(5)
            ->get();

        return view('warga.dashboard', compact('user', 'penduduk', 'anggotaKeluarga', 'suratTerakhir', 'notifikasi'));
    }

    public function suratIndex(): View
    {
        $user = Auth::user();
        $daftarSurat = PermohonanSurat::where('id_user', $user->id_user)
            ->with(['kodeSurat', 'penduduk'])
            ->latest()
            ->paginate(10);

        return view('warga.surat_index', compact('daftarSurat'));
    }

    public function suratCreate(Request $request): View
    {
        $user = Auth::user();
        $penduduk = $user->penduduk;

        $jenisSurat = KodeSurat::with('syaratSurat')->get();

        $anggotaKeluarga = collect();
        if ($penduduk && $penduduk->id_kartu_keluarga) {
            $anggotaKeluarga = Penduduk::where('id_kartu_keluarga', $penduduk->id_kartu_keluarga)->get();
        } else {
            $anggotaKeluarga = collect([$penduduk]);
        }

        $selectedKodeSurat = null;
        if ($request->has('kode')) {
            $selectedKodeSurat = KodeSurat::with('syaratSurat')->find($request->query('kode'));
        }

        return view('warga.surat_create', compact('jenisSurat', 'anggotaKeluarga', 'selectedKodeSurat'));
    }

    public function suratStore(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'id_kode_surat' => 'required|exists:kode_surat,id_kode_surat',
            'id_penduduk' => 'required|exists:penduduk,id_penduduk',
            'keperluan' => 'required|string|max:500',
            'keterangan_tambahan' => 'nullable|string|max:1000',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp,heic|max:5120',
        ]);

        $tokenQr = Str::upper(Str::random(12));

        $permohonan = PermohonanSurat::create([
            'id_user' => $user->id_user,
            'id_penduduk' => $validated['id_penduduk'],
            'id_kode_surat' => $validated['id_kode_surat'],
            'tanggal_pengajuan' => now()->toDateString(),
            'keperluan' => $validated['keperluan'],
            'keterangan_tambahan' => $validated['keterangan_tambahan'] ?? null,
            'status' => 'menunggu_verifikasi',
            'token_qr' => $tokenQr,
        ]);

        // Simpan file berkas lampiran
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $idSyarat => $file) {
                if ($file && $file->isValid()) {
                    try {
                        $extension = $file->getClientOriginalExtension() ?: 'jpg';
                        $filename = time().'_'.$idSyarat.'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$extension;
                        $path = $file->storeAs('lampiran_surat', $filename, 'public');

                        LampiranPermohonan::create([
                            'id_permohonan_surat' => $permohonan->id_permohonan_surat,
                            'id_syarat_surat' => $idSyarat,
                            'nama_file' => $file->getClientOriginalName(),
                            'file_path' => $path ?: ('lampiran_surat/'.$filename),
                            'status_validasi' => 'menunggu',
                        ]);
                    } catch (\Throwable $e) {
                        Log::warning('Gagal menyimpan file lampiran: '.$e->getMessage());

                        // Tetap catat lampiran agar proses pengajuan surat tidak gagal
                        LampiranPermohonan::create([
                            'id_permohonan_surat' => $permohonan->id_permohonan_surat,
                            'id_syarat_surat' => $idSyarat,
                            'nama_file' => $file->getClientOriginalName(),
                            'file_path' => 'lampiran_surat/'.$file->getClientOriginalName(),
                            'status_validasi' => 'menunggu',
                        ]);
                    }
                }
            }
        }

        // Catat riwayat tahap pertama
        RiwayatStatusSurat::create([
            'id_permohonan_surat' => $permohonan->id_permohonan_surat,
            'id_user' => $user->id_user,
            'tahapan' => 'Pengajuan Berkas oleh Warga',
            'status_tahap' => 'diajukan',
            'catatan_petugas' => 'Permohonan berhasil dikirim oleh pemohon. Menunggu pemeriksaan berkas oleh Kasi Pelayanan.',
        ]);

        // Buat notifikasi ke warga
        Notifikasi::create([
            'id_user' => $user->id_user,
            'judul' => 'Permohonan Surat Terkirim',
            'pesan' => 'Permohonan surat Anda telah diterima dengan kode pelacakan: '.$tokenQr.'. Petugas akan memvalidasi dokumen Anda.',
            'kanal' => 'web',
            'tautan' => route('warga.surat.detail', $permohonan->id_permohonan_surat),
        ]);

        return redirect()->route('warga.surat.detail', $permohonan->id_permohonan_surat)
            ->with('success', 'Permohonan surat berhasil dikirim! Silakan pantau status verifikasinya.');
    }

    public function suratDetail(int $id): View
    {
        $user = Auth::user();
        $permohonan = PermohonanSurat::where('id_permohonan_surat', $id)
            ->where('id_user', $user->id_user)
            ->with(['kodeSurat', 'penduduk.kartuKeluarga.rt.dusun', 'lampiranPermohonan.syaratSurat', 'riwayatStatus.petugas'])
            ->firstOrFail();

        return view('warga.surat_detail', compact('permohonan'));
    }

    public function pengaduanIndex(): View
    {
        $user = Auth::user();
        $pengaduan = LayananPengaduan::where('id_user', $user->id_user)
            ->with('dusun')
            ->latest()
            ->paginate(10);

        $dusunList = WilayahDusun::all();

        return view('warga.pengaduan', compact('pengaduan', 'dusunList'));
    }

    public function pengaduanStore(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'id_dusun' => 'nullable|exists:wilayah_dusun,id_dusun',
            'judul_laporan' => 'required|string|max:200',
            'kategori' => 'required|string',
            'isi_laporan' => 'required|string|max:2000',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            try {
                $fotoPath = $request->file('foto_bukti')->store('pengaduan', 'public');
            } catch (\Throwable $e) {
                Log::warning('Gagal upload foto pengaduan: '.$e->getMessage());
                $fotoPath = 'pengaduan/'.$request->file('foto_bukti')->getClientOriginalName();
            }
        }

        LayananPengaduan::create([
            'id_user' => $user->id_user,
            'id_dusun' => $validated['id_dusun'] ?? $user->id_dusun,
            'judul_laporan' => $validated['judul_laporan'],
            'kategori' => $validated['kategori'],
            'isi_laporan' => $validated['isi_laporan'],
            'foto_bukti' => $fotoPath,
            'status' => 'diajukan',
        ]);

        return back()->with('success', 'Aspirasi / pengaduan Anda berhasil disampaikan kepada aparat kelurahan.');
    }

    public function getUnreadNotifications(): JsonResponse
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['unread_count' => 0, 'notifications' => []]);
        }

        $unreadCount = Notifikasi::where('id_user', $user->id_user)
            ->where('is_read', false)
            ->count();

        $notifications = Notifikasi::where('id_user', $user->id_user)
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($notif): array {
                return [
                    'id_notifikasi' => $notif->id_notifikasi,
                    'judul' => $notif->judul,
                    'pesan' => $notif->pesan,
                    'is_read' => (bool) $notif->is_read,
                    'tautan' => $notif->tautan,
                    'waktu' => $notif->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    public function markNotificationAsRead(int $id): JsonResponse
    {
        $user = Auth::user();
        $notif = Notifikasi::where('id_user', $user->id_user)->find($id);
        if ($notif) {
            $notif->is_read = true;
            $notif->save();
        }

        return response()->json(['success' => true]);
    }

    public function markAllNotificationsAsRead(): JsonResponse
    {
        $user = Auth::user();
        Notifikasi::where('id_user', $user->id_user)->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
