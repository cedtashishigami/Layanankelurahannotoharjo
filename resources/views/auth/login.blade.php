<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun – Sistem Informasi Kelurahan Notoharjo</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-lampung-tengah.png') }}">

    <!-- Tailwind CDN -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:  '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .bg-pattern {
            background-image: url('/kantor-notoharjo.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .pattern-dots::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(10, 50, 20, 0.55);
            pointer-events: none;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(20px);
        }

        .input-field {
            transition: all 0.2s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(22,163,74,0.15);
        }

        .btn-login {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(22,163,74,0.4);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #15803d, #166534);
            box-shadow: 0 6px 20px rgba(22,163,74,0.5);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .logo-float {
            animation: float 4s ease-in-out infinite;
        }

        .decorative-circle-1 {
            width: 300px; height: 300px;
            background: rgba(22,163,74,0.15);
            border-radius: 50%;
            position: absolute;
            top: -80px; left: -80px;
            filter: blur(1px);
        }

        .decorative-circle-2 {
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            position: absolute;
            bottom: -40px; right: -40px;
        }

        .decorative-circle-3 {
            width: 120px; height: 120px;
            background: rgba(255,221,0,0.1);
            border-radius: 50%;
            position: absolute;
            top: 40%; right: 10%;
        }
    </style>
</head>

<body class="min-h-screen bg-pattern pattern-dots relative overflow-hidden flex items-center justify-center p-4">

    <!-- Decorative Circles -->
    <div class="decorative-circle-1"></div>
    <div class="decorative-circle-2"></div>
    <div class="decorative-circle-3"></div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-0 shadow-2xl rounded-3xl overflow-hidden min-h-[600px]">

        <!-- === LEFT PANEL: Branding === -->
        <div class="relative bg-gradient-to-br from-primary-800 via-primary-900 to-slate-900 flex flex-col items-center justify-center p-10 text-white text-center space-y-6 hidden lg:flex">
            <!-- Subtle inner pattern -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 20px 20px;"></div>

            <!-- Yellow top accent bar -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-400"></div>

            <!-- Logo -->
            <div class="relative logo-float">
                <div class="w-36 h-36 rounded-full bg-white/10 border-2 border-white/20 flex items-center justify-center shadow-2xl p-2">
                    <img src="{{ asset('logo-lampung-tengah.png') }}"
                         alt="Logo Kabupaten Lampung Tengah"
                         class="w-full h-full object-contain drop-shadow-lg">
                </div>
            </div>

            <!-- Text -->
            <div class="space-y-3 relative z-10">
                <div class="flex items-center justify-center space-x-2">
                    <div class="h-px w-8 bg-yellow-400"></div>
                    <span class="text-yellow-300 text-[11px] font-bold uppercase tracking-widest">Kabupaten Lampung Tengah</span>
                    <div class="h-px w-8 bg-yellow-400"></div>
                </div>
                <h1 class="text-2xl font-black tracking-tight leading-tight">
                    Sistem Informasi<br>
                    <span class="text-yellow-300">Kelurahan Notoharjo</span>
                </h1>
                <p class="text-sm text-primary-200 leading-relaxed max-w-xs mx-auto">
                    Layanan administrasi kependudukan digital untuk masyarakat Notoharjo, Kecamatan Trimurjo.
                </p>
            </div>

            <!-- Feature Pills -->
            <div class="flex flex-wrap justify-center gap-2 relative z-10 pt-2">
                <span class="px-3 py-1 bg-white/10 border border-white/20 rounded-full text-[10px] font-semibold text-white/90 flex items-center space-x-1.5">
                    <i class="fa-solid fa-file-signature text-yellow-300 text-[9px]"></i>
                    <span>Surat Mandiri Online</span>
                </span>
                <span class="px-3 py-1 bg-white/10 border border-white/20 rounded-full text-[10px] font-semibold text-white/90 flex items-center space-x-1.5">
                    <i class="fa-solid fa-qrcode text-yellow-300 text-[9px]"></i>
                    <span>QR Verifikasi Digital</span>
                </span>
                <span class="px-3 py-1 bg-white/10 border border-white/20 rounded-full text-[10px] font-semibold text-white/90 flex items-center space-x-1.5">
                    <i class="fa-solid fa-shield-halved text-yellow-300 text-[9px]"></i>
                    <span>Otorisasi 3 Jenjang</span>
                </span>
                <span class="px-3 py-1 bg-white/10 border border-white/20 rounded-full text-[10px] font-semibold text-white/90 flex items-center space-x-1.5">
                    <i class="fa-solid fa-chart-pie text-yellow-300 text-[9px]"></i>
                    <span>Transparansi APBD</span>
                </span>
            </div>

            <!-- Bottom credit -->
            <div class="absolute bottom-5 left-0 right-0 text-center text-[10px] text-primary-400">
                <span>Kelurahan Notoharjo &bull; Kec. Trimurjo &bull; Kab. Lampung Tengah &bull; 34172</span>
            </div>
        </div>

        <!-- === RIGHT PANEL: Login Form === -->
        <div class="card-glass flex flex-col justify-center p-8 sm:p-10 space-y-6">

            <!-- Mobile logo (shown only on small screens) -->
            <div class="flex lg:hidden items-center space-x-3 mb-2">
                <img src="{{ asset('logo-lampung-tengah.png') }}"
                     alt="Logo Kelurahan Notoharjo"
                     class="w-12 h-12 object-contain">
                <div>
                    <p class="text-xs font-bold text-primary-700 uppercase tracking-wide">Kelurahan Notoharjo</p>
                    <p class="text-[10px] text-slate-500">Kec. Trimurjo · Lampung Tengah</p>
                </div>
            </div>

            <!-- Form Header -->
            <div class="space-y-1">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Selamat Datang</h2>
                <p class="text-sm text-slate-500">Masuk menggunakan akun terdaftar untuk mengakses layanan kelurahan.</p>
            </div>

            <!-- Error / Success Alerts -->
            @if($errors->any())
                <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-medium flex items-start space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 shrink-0"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-medium flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email / NIK -->
                <div class="space-y-1.5">
                    <label for="login" class="block text-xs font-bold text-slate-700">Email atau NIK KTP</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-slate-400 text-sm"></i>
                        </div>
                        <input
                            type="text"
                            name="login"
                            id="login"
                            value="{{ old('login') }}"
                            required
                            autocomplete="username"
                            placeholder="admin@notoharjo.desa.id atau NIK"
                            class="input-field w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1.5" x-data="{ show: false }">
                    <label for="password" class="block text-xs font-bold text-slate-700">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-slate-400 text-sm"></i>
                        </div>
                        <input
                            :type="show ? 'text' : 'password'"
                            name="password"
                            id="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="input-field w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white"
                        >
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition">
                            <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember + Link -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-slate-600 font-medium">Ingat saya</span>
                    </label>
                    <a href="{{ route('register') }}" class="font-bold text-primary-600 hover:text-primary-700 transition">
                        Belum punya akun? Daftar
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login w-full py-3.5 text-white font-bold rounded-xl text-sm flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk ke Sistem</span>
                </button>
            </form>

            <!-- Back to Home -->
            <div class="text-center pt-1">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-1.5 text-xs text-slate-400 hover:text-primary-600 transition font-medium">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Halaman Utama</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Alpine.js for password toggle -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</body>
</html>
