<?php

namespace App\Http\Controllers;

use App\Models\PermohonanSurat;
use Illuminate\View\View;

class VerifikasiSuratController extends Controller
{
    public function verify(string $token): View
    {
        $surat = PermohonanSurat::with([
            'pemohon',
            'penduduk.kartuKeluarga.rt.dusun',
            'kodeSurat',
            'riwayatStatus.petugas',
        ])
            ->where('token_qr', $token)
            ->first();

        return view('verifikasi.surat', compact('surat', 'token'));
    }
}
