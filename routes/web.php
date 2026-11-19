<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VerifikasiSuratController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// --- Publik Kelurahan Notoharjo ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita.index');
Route::get('/berita/{slug}', [HomeController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/potensi', [HomeController::class, 'potensi'])->name('potensi.index');
Route::get('/transparansi', [HomeController::class, 'transparansi'])->name('transparansi.index');
Route::get('/agenda', [HomeController::class, 'agenda'])->name('agenda.index');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri.index');
Route::get('/lacak-surat', [HomeController::class, 'lacakSurat'])->name('lacak.surat');
Route::get('/pengaduan', [HomeController::class, 'pengaduan'])->name('pengaduan.publik');
Route::get('/diagram-sistem', function () {
    return response()->file(public_path('diagram-sistem.html'));
})->name('diagram.sistem');

// --- Verifikasi Keabsahan Surat via QR Code ---
Route::get('/verifikasi-surat/{token}', [VerifikasiSuratController::class, 'verify'])->name('verifikasi.surat');

// --- Serving File Lampiran Storage (Vercel Serverless Fallback) ---
Route::get('/storage/{path}', function (string $path) {
    $disk = Storage::disk('public');
    if ($disk->exists($path)) {
        return $disk->response($path);
    }
    abort(404);
})->where('path', '.*')->name('storage.file');

// --- Autentikasi Pengguna ---
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- Notifikasi Real-Time Pengguna ---
Route::middleware('auth')->group(function (): void {
    Route::get('/notifikasi/unread', [WargaController::class, 'getUnreadNotifications'])->name('notifikasi.unread');
    Route::post('/notifikasi/{id}/baca', [WargaController::class, 'markNotificationAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/baca-semua', [WargaController::class, 'markAllNotificationsAsRead'])->name('notifikasi.readAll');
});

// --- Portal Mandiri Warga ---
Route::middleware('auth')->prefix('warga')->name('warga.')->group(function (): void {
    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('dashboard');
    Route::get('/surat', [WargaController::class, 'suratIndex'])->name('surat.index');
    Route::get('/surat/buat', [WargaController::class, 'suratCreate'])->name('surat.create');
    Route::post('/surat', [WargaController::class, 'suratStore'])->name('surat.store');
    Route::get('/surat/{id}', [WargaController::class, 'suratDetail'])->name('surat.detail');
    Route::get('/pengaduan', [WargaController::class, 'pengaduanIndex'])->name('pengaduan.index');
    Route::post('/pengaduan', [WargaController::class, 'pengaduanStore'])->name('pengaduan.store');
});

// --- Panel Administrasi Aparat Kelurahan ---
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/surat', [AdminController::class, 'suratIndex'])->name('surat.index');
    Route::get('/surat/{id}', [AdminController::class, 'suratDetail'])->name('surat.detail');
    Route::post('/surat/{id}/action', [AdminController::class, 'suratAction'])->name('surat.action');
    Route::get('/surat/{id}/cetak', [AdminController::class, 'suratCetak'])->name('surat.cetak');
    Route::get('/kependudukan', [AdminController::class, 'kependudukanIndex'])->name('kependudukan.index');
    Route::get('/mutasi', [AdminController::class, 'mutasiIndex'])->name('mutasi.index');
    Route::post('/mutasi', [AdminController::class, 'mutasiStore'])->name('mutasi.store');
    Route::get('/pengaduan', [AdminController::class, 'pengaduanIndex'])->name('pengaduan.index');
    Route::post('/pengaduan/{id}/tanggapi', [AdminController::class, 'pengaduanTanggapi'])->name('pengaduan.tanggapi');
    Route::get('/potensi', [AdminController::class, 'potensiIndex'])->name('potensi.index');
    Route::post('/potensi', [AdminController::class, 'potensiStore'])->name('potensi.store');
    Route::get('/transparansi', [AdminController::class, 'transparansiIndex'])->name('transparansi.index');
    Route::post('/transparansi', [AdminController::class, 'transparansiStore'])->name('transparansi.store');
    Route::get('/berita', [AdminController::class, 'beritaIndex'])->name('berita.index');
    Route::post('/berita', [AdminController::class, 'beritaStore'])->name('berita.store');
    Route::get('/agenda', [AdminController::class, 'agendaIndex'])->name('agenda.index');
    Route::post('/agenda', [AdminController::class, 'agendaStore'])->name('agenda.store');
    Route::get('/laporan-pengujian', [AdminController::class, 'laporanPengujian'])->name('laporan.pengujian');
    Route::get('/galeri', [AdminController::class, 'galeriIndex'])->name('galeri.index');
    Route::post('/galeri', [AdminController::class, 'galeriStore'])->name('galeri.store');
    Route::delete('/galeri/{id}', [AdminController::class, 'galeriDestroy'])->name('galeri.destroy');
});
