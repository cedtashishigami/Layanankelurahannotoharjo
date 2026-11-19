<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationService
{
    /**
     * Kirim notifikasi pesan ke WhatsApp Warga
     */
    public static function kirim(User $user, string $judul, string $pesan, ?string $tautan = null): void
    {
        // 1. Simpan ke database notifikasi internal
        Notifikasi::create([
            'id_user' => $user->id_user,
            'judul' => $judul,
            'pesan' => $pesan,
            'kanal' => 'whatsapp',
            'tautan' => $tautan,
            'is_read' => false,
        ]);

        $noHp = $user->no_hp ?? $user->penduduk?->no_telepon;
        if (! $noHp) {
            return;
        }

        // Format nomor HP ke 62xxxx
        $targetHp = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $noHp));

        $pesanWa = "*Pemberitahuan Kelurahan Notoharjo*\n\n"
            ."*{$judul}*\n"
            ."Yth. {$user->name},\n\n"
            ."{$pesan}\n\n"
            .($tautan ? "Tautan Dokumen: {$tautan}\n\n" : '')
            .'_Pesan otomatis Sistem Informasi Kelurahan Notoharjo, Kec. Trimurjo._';

        // 2. Log simulasi pengiriman WhatsApp
        Log::channel('single')->info("WhatsApp Dispatched to [{$targetHp}]: {$pesanWa}");

        // 3. Integrasi API Gateway (jika API KEY diatur di .env)
        $token = env('WHATSAPP_API_TOKEN');
        if ($token) {
            try {
                Http::withHeaders([
                    'Authorization' => $token,
                ])->post(env('WHATSAPP_API_URL', 'https://api.fonnte.com/send'), [
                    'target' => $targetHp,
                    'message' => $pesanWa,
                ]);
            } catch (\Exception $e) {
                Log::warning('Gagal mengirim WhatsApp Gateway: '.$e->getMessage());
            }
        }
    }
}
