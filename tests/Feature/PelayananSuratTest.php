<?php

namespace Tests\Feature;

use App\Models\KodeSurat;
use App\Models\Notifikasi;
use App\Models\Penduduk;
use App\Models\PermohonanSurat;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelayananSuratTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_halaman_publik_dapat_diakses(): void
    {
        $this->get('/')->assertStatus(200)->assertSee('KELURAHAN NOTOHARJO');
        $this->get('/profil')->assertStatus(200)->assertSee('Bedeng 17 Polos');
        $this->get('/potensi')->assertStatus(200)->assertSee('Pasar Tradisional Welit');
        $this->get('/transparansi')->assertStatus(200)->assertSee('Transparansi');
        $this->get('/agenda')->assertStatus(200)->assertSee('Kalender Kegiatan');
        $this->get('/berita')->assertStatus(200)->assertSee('Kabar Desa');
        $this->get('/lacak-surat')->assertStatus(200)->assertSee('Pelacakan Status Surat');
    }

    public function test_warga_dapat_login_ke_portal_mandiri(): void
    {
        $response = $this->post('/login', [
            'login' => 'cetta@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/warga/dashboard');
        $this->assertAuthenticated();
    }

    public function test_aparat_desa_dapat_login_ke_panel_admin(): void
    {
        $response = $this->post('/login', [
            'login' => 'lurah@notoharjo.desa.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    public function test_verifikasi_qr_code_surat_berhasil(): void
    {
        $user = User::where('role', 'warga')->first();
        $penduduk = Penduduk::first();
        $kodeSurat = KodeSurat::first();

        $surat = PermohonanSurat::create([
            'id_user' => $user->id_user,
            'id_penduduk' => $penduduk->id_penduduk,
            'id_kode_surat' => $kodeSurat->id_kode_surat,
            'nomor_surat' => '503/001/NT/2026',
            'tanggal_pengajuan' => now()->toDateString(),
            'keperluan' => 'Uji Coba Pengesahan',
            'status' => 'selesai',
            'token_qr' => 'TESTQR123456',
            'tanggal_disahkan' => now()->toDateString(),
        ]);

        $response = $this->get('/verifikasi-surat/TESTQR123456');
        $response->assertStatus(200);
        $response->assertSee('DOKUMEN ASLI');
        $response->assertSee('503/001/NT/2026');
    }

    public function test_admin_dapat_filter_kependudukan_via_ajax(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Standard request
        $response = $this->actingAs($admin)->get('/admin/kependudukan');
        $response->assertStatus(200)->assertSee('Data Induk Kependudukan');

        // AJAX request with query
        $ajaxResponse = $this->actingAs($admin)->get('/admin/kependudukan?q=Cetta', [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
        $ajaxResponse->assertStatus(200);
        $ajaxResponse->assertSee('Cetta Nafis Kurnia');
    }

    public function test_admin_dapat_filter_surat_via_ajax(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Standard request
        $response = $this->actingAs($admin)->get('/admin/surat');
        $response->assertStatus(200)->assertSee('Verifikasi Persuratan');

        // AJAX request with query
        $ajaxResponse = $this->actingAs($admin)->get('/admin/surat?status=menunggu_verifikasi', [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
        $ajaxResponse->assertStatus(200);
    }

    public function test_api_notifikasi_real_time_warga(): void
    {
        $user = User::where('role', 'warga')->first();

        // Buat notifikasi uji
        Notifikasi::create([
            'id_user' => $user->id_user,
            'judul' => 'Surat Disetujui',
            'pesan' => 'Surat Anda telah disahkan.',
            'kanal' => 'web',
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)->getJson('/notifikasi/unread');
        $response->assertStatus(200)
            ->assertJsonStructure(['unread_count', 'notifications'])
            ->assertJson(['unread_count' => 1]);

        $notifId = $response->json('notifications.0.id_notifikasi');

        // Tandai sudah dibaca
        $this->actingAs($user)->postJson("/notifikasi/{$notifId}/baca")
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        // Cek unread berkurang jadi 0
        $this->actingAs($user)->getJson('/notifikasi/unread')
            ->assertJson(['unread_count' => 0]);
    }
}
