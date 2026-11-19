<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun – Sistem Informasi Kelurahan Notoharjo</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-lampung-tengah.png') }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-pattern {
            background-color: #14532d;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(22,163,74,0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(21,128,61,0.3) 0%, transparent 40%),
                radial-gradient(circle at 60% 80%, rgba(20,83,45,0.5) 0%, transparent 40%);
        }
        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(22,163,74,0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(22,163,74,0.4);
        }
        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(22,163,74,0.5);
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="min-h-screen bg-pattern flex items-center justify-center p-4" style="background-image: radial-gradient(circle at 20% 50%, rgba(22,163,74,0.4) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(21,128,61,0.3) 0%, transparent 40%); background-color: #14532d;">

    <!-- Dot pattern overlay -->
    <div class="fixed inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="relative z-10 w-full max-w-lg mx-auto">
        <!-- Card -->
        <div class="bg-white/97 backdrop-blur rounded-3xl shadow-2xl overflow-hidden">
            <!-- Top accent bar -->
            <div class="h-1 bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-400"></div>

            <div class="p-8 sm:p-10 space-y-6">
                <!-- Header -->
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('logo-lampung-tengah.png') }}"
                         alt="Logo Kabupaten Lampung Tengah"
                         class="w-14 h-14 object-contain shrink-0">
                    <div>
                        <h1 class="text-xl font-black text-slate-900 tracking-tight leading-tight">Pendaftaran Akun Warga</h1>
                        <p class="text-xs text-slate-500 mt-0.5">Kelurahan Notoharjo · Kec. Trimurjo · Lampung Tengah</p>
                    </div>
                </div>

                <!-- Info banner -->
                <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs flex items-start space-x-2.5">
                    <i class="fa-solid fa-circle-info text-amber-500 mt-0.5 shrink-0"></i>
                    <span>NIK Anda akan dicocokkan dengan arsip kependudukan resmi Kelurahan Notoharjo. Pastikan data sesuai e-KTP.</span>
                </div>

                <!-- Errors -->
                @if($errors->any())
                    <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-medium flex items-start space-x-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 shrink-0"></i>
                        <div class="space-y-0.5">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="space-y-1.5">
                        <label for="nik" class="block text-xs font-bold text-slate-700">Nomor Induk Kependudukan (NIK)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-id-card text-slate-400 text-sm"></i>
                            </div>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required maxlength="16"
                                   placeholder="16 digit NIK sesuai e-KTP"
                                   class="input-field w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:bg-white transition">
                        </div>
                        <p class="text-[11px] text-slate-400">Demo: NIK <code class="bg-slate-100 px-1 rounded font-mono">1802012003880003</code> (Siti Nurhayati)</p>
                    </div>

                    <div class="space-y-1.5">
                        <label for="nama_sesuai_ktp" class="block text-xs font-bold text-slate-700">Nama Lengkap (Sesuai KTP)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-user text-slate-400 text-sm"></i>
                            </div>
                            <input type="text" name="nama_sesuai_ktp" id="nama_sesuai_ktp" value="{{ old('nama_sesuai_ktp') }}" required
                                   placeholder="Nama lengkap tanpa gelar"
                                   class="input-field w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:bg-white transition">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-bold text-slate-700">Alamat Email Aktif</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-slate-400 text-sm"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   placeholder="email@gmail.com"
                                   class="input-field w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:bg-white transition">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="no_hp" class="block text-xs font-bold text-slate-700">Nomor WhatsApp / HP</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-brands fa-whatsapp text-slate-400 text-sm"></i>
                            </div>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required
                                   placeholder="08xxxxxxxxxx"
                                   class="input-field w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:bg-white transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700">Kata Sandi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-slate-400 text-sm"></i>
                                </div>
                                <input type="password" name="password" id="password" required
                                       placeholder="Min. 6 karakter"
                                       class="input-field w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:bg-white transition">
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700">Ulangi Sandi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-slate-400 text-sm"></i>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       placeholder="Konfirmasi"
                                       class="input-field w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:bg-white transition">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full py-3.5 text-white font-bold rounded-xl text-sm flex items-center justify-center space-x-2 mt-2">
                        <i class="fa-solid fa-user-check"></i>
                        <span>Daftar & Verifikasi NIK</span>
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="text-center text-xs text-slate-500 pt-2 border-t border-slate-100">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-bold text-green-700 hover:text-green-800 transition">Masuk di Sini</a>
                    &bull;
                    <a href="{{ route('home') }}" class="font-medium text-slate-400 hover:text-slate-600 transition">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</body>
</html>
