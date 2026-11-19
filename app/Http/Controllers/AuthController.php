<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $credentials['login'];
        $password = $credentials['password'];

        // Coba cari user berdasarkan email atau NIK
        $user = User::where('email', $loginInput)
            ->orWhere('nik', $loginInput)
            ->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return back()->withErrors([
                'login' => 'Email/NIK atau password yang Anda masukkan salah.',
            ])->onlyInput('login');
        }

        if (! $user->is_active) {
            return back()->withErrors([
                'login' => 'Akun Anda dinonaktifkan. Silakan hubungi aparat kelurahan.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($user->isPegawai()) {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, '.$user->name.' ('.$user->jabatan.').');
        }

        return redirect()->intended(route('warga.dashboard'))
            ->with('success', 'Selamat datang, '.$user->name.'. Layanan mandiri siap digunakan.');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nik' => 'required|digits:16',
            'nama_sesuai_ktp' => 'required|string|max:150',
            'email' => 'required|email|max:100|unique:users,email',
            'no_hp' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Cek apakah NIK terdaftar di database master Penduduk Notoharjo
        $penduduk = Penduduk::where('nik', $validated['nik'])->first();

        if (! $penduduk) {
            return back()->withErrors([
                'nik' => 'NIK tidak terdaftar dalam data master penduduk Kelurahan Notoharjo. Pastikan NIK Anda sesuai KTP atau hubungi kantor kelurahan.',
            ])->withInput();
        }

        // Cek apakah NIK sudah punya akun user
        $sudahAda = User::where('nik', $validated['nik'])->exists();
        if ($sudahAda) {
            return back()->withErrors([
                'nik' => 'NIK ini sudah memiliki akun terdaftar. Silakan login langsung.',
            ])->withInput();
        }

        // Ambil dusun dari kartu keluarga penduduk
        $dusunId = $penduduk->kartuKeluarga?->rt?->id_dusun;

        $user = User::create([
            'id_penduduk' => $penduduk->id_penduduk,
            'id_dusun' => $dusunId,
            'name' => $penduduk->nama_lengkap,
            'email' => $validated['email'],
            'nik' => $penduduk->nik,
            'no_hp' => $validated['no_hp'],
            'password' => Hash::make($validated['password']),
            'role' => 'warga',
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('warga.dashboard')
            ->with('success', 'Pendaftaran berhasil! Akun Anda telah terverifikasi dengan data kependudukan Kelurahan Notoharjo.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', 'Anda telah berhasil keluar.');
    }
}
