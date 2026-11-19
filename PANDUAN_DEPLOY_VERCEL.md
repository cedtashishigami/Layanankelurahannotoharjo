# Panduan Deploy Web Notoharjo ke Vercel

> [!IMPORTANT]
> Vercel adalah platform **serverless** — tidak ada session berbasis file, tidak ada `php artisan serve`, dan filesystem tidak persisten. Database MySQL **wajib** menggunakan layanan cloud (PlanetScale, Aiven, Neon, dsb), bukan XAMPP lokal.

---

## Daftar Isi

1. [Prasyarat](#1-prasyarat)
2. [Struktur File yang Diperlukan](#2-struktur-file-yang-diperlukan)
3. [Siapkan Database Cloud](#3-siapkan-database-cloud)
4. [Konfigurasi Environment Variables](#4-konfigurasi-environment-variables)
5. [Push ke GitHub](#5-push-ke-github)
6. [Import & Deploy di Vercel](#6-import--deploy-di-vercel)
7. [Jalankan Migrasi & Seeder](#7-jalankan-migrasi--seeder)
8. [Upload Aset Gambar ke Storage Publik](#8-upload-aset-gambar-ke-storage-publik)
9. [Checklist Setelah Deploy](#9-checklist-setelah-deploy)
10. [Troubleshooting Umum](#10-troubleshooting-umum)

---

## 1. Prasyarat

| Kebutuhan | Keterangan |
|:---|:---|
| Akun **Vercel** | [vercel.com](https://vercel.com) — gratis (Hobby Plan) |
| Akun **GitHub** | Repo harus public atau private dengan akses Vercel |
| Database MySQL cloud | Rekomendasi: **PlanetScale** (gratis) atau **Aiven** / **Clever Cloud** |
| PHP **8.3+** | Sudah dipenuhi oleh project ini |
| Node.js **18+** | Untuk build Vite/Tailwind |
| Composer | Untuk install dependensi PHP |

---

## 2. Struktur File yang Diperlukan

Pastikan file-file berikut **ada dan ter-commit** di repositori sebelum deploy:

```
web_notoharjo/
├── api/
│   └── index.php          ← Serverless entrypoint Vercel (WAJIB)
├── vercel.json             ← Konfigurasi routing & build Vercel (WAJIB)
├── composer.json           ✅ Sudah ada
├── composer.lock           ✅ Sudah ada
├── package.json            ✅ Sudah ada
├── package-lock.json       ⚠️  Buat dengan: npm install (sekali)
├── vite.config.js          ✅ Sudah ada
├── .env.example            ✅ Sudah ada (jangan commit .env asli!)
├── public/
│   ├── index.php           ✅ Sudah ada
│   ├── .htaccess           ✅ Sudah ada (untuk Apache fallback)
│   └── images/             ✅ Semua aset gambar statis
├── bootstrap/
│   └── app.php             ✅ Sudah ada
├── config/
├── routes/
├── resources/
├── database/
│   └── migrations/
└── storage/
    └── framework/
        ├── cache/
        ├── sessions/       ⚠️  Harus writeable (Vercel: gunakan DB session)
        └── views/          ✅ Cache view (writeable di /tmp)
```

> [!NOTE]
> Vercel menyediakan direktori `/tmp` sebagai satu-satunya lokasi writeable. Laravel sudah dikonfigurasi untuk cache ke `/tmp` secara otomatis melalui `vercel.json`.

### File yang Harus Ada di Git (dan TIDAK di .gitignore)

```
✅ composer.lock
✅ package-lock.json   ← generate dengan: npm install
✅ api/index.php
✅ vercel.json
✅ public/images/*     ← semua gambar statis
✅ public/*.jpg, *.png, *.ico
```

### File yang TIDAK boleh di-commit

```
❌ .env               (berisi kredensial!)
❌ /vendor            (di-install saat build)
❌ /node_modules      (di-install saat build)
❌ /public/build      (di-generate saat build)
❌ /storage/*.key
```

---

## 3. Siapkan Database Cloud (Gratis & Cepat)

Database lokal di laptop Anda (`127.0.0.1` / XAMPP) tidak bisa diakses langsung oleh Vercel yang ada di internet. Anda perlu 1 database MySQL online gratis.

### Pilihan Paling Mudah: TiDB Serverless (MySQL 100% Kompatibel, Gratis Selamanya, Tanpa Kartu Kredit)

1. Buka [tidbcloud.com](https://tidbcloud.com) → Login dengan Google (1 klik).
2. Buat Cluster: pilih **Serverless (Free)**.
3. Beri nama database: `web_notoharjo`.
4. Klik tombol **Connect** → pilih **Type: General** atau **Language: PHP**.
5. Anda akan mendapatkan:
   - **Host** (contoh: `gateway01.ap-southeast-1.prod.aws.tidbcloud.com`)
   - **Port**: `4000` (atau `3306`)
   - **User** (contoh: `xxxxx.root`)
   - **Password** (yang di-generate)
6. Masukkan data kredensial tersebut ke Environment Variables Vercel!

---

### Cara Memasukkan Seluruh Data Web Notoharjo ke Database Cloud:

Saya sudah membuatkan file dump SQL dari database lokal Anda di:
📂 `c:\xampp\htdocs\web_notoharjo\database_notoharjo.sql`

Anda cukup memilih salah satu cara:
- **Cara 1 (Web Console TiDB)**: Buka tab **Chat2Query / SQL Editor** di web TiDB → upload file `database_notoharjo.sql` → klik **Run**.
- **Cara 2 (Artisan Migrate dari Laptop)**: Ubah sementara `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD` di file `.env` laptop Anda dengan akun database cloud tadi, lalu jalankan di terminal:
  ```powershell
  php artisan migrate:fresh --seed
  ```
  *(Setelah selesai, kembalikan `.env` ke localhost).*

---

## 4. Konfigurasi Environment Variables (Siap Copy-Paste)

Nilai-nilai di bawah ini sudah **disesuaikan 100% dengan konfigurasi project `web_notoharjo` Anda** (termasuk `APP_KEY` asli proyek Anda):

```dotenv
# App Kelurahan Notoharjo
APP_NAME="Kelurahan Notoharjo"
APP_ENV=production
APP_KEY=base64:vJ4/T83SPfmE6L3eHjjPSOI/gnhjXWq/KjLm1mZk6iY=
APP_DEBUG=false
APP_URL=https://layanankelurahannotoharjo.vercel.app

# Lokalisasi
APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_FAKER_LOCALE=id_ID

# Database MySQL Online (Ganti HOST & PASSWORD dari Database Cloud Gratis Anda)
DB_CONNECTION=mysql
DB_HOST=<host_cloud_database_anda>
DB_PORT=3306
DB_DATABASE=web_notoharjo
DB_USERNAME=<user_database_cloud>
DB_PASSWORD=<password_database_cloud>
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt

# Session & Cache (Sudah pakai database sesuai sistem Laravel Anda)
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# File & Log
FILESYSTEM_DISK=local
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

> [!NOTE]
> File dump database lokal Anda sudah diekspor lengkap ke: [`database_notoharjo.sql`](file:///c:/xampp/htdocs/web_notoharjo/database_notoharjo.sql). File ini berisi seluruh tabel, data warga (termasuk Cetta Nafis Kurnia & keluarga), potensi desa, agenda, dan pengguna siap import ke cloud.

> [!CAUTION]
> Jangan pernah menggunakan `SESSION_DRIVER=file` atau `CACHE_STORE=file` di Vercel. Filesystem tidak persisten antar-request — session akan hilang setiap request!

### Generate APP_KEY

Jalankan di komputer lokal Anda:

```bash
php artisan key:generate --show
```

Salin hasilnya (`base64:xxx...`) dan masukkan sebagai nilai `APP_KEY` di Vercel.

---

## 5. Push ke GitHub

### Jika belum punya repo GitHub:

```bash
# Di folder project
cd c:\xampp\htdocs\web_notoharjo

# Inisialisasi git (jika belum)
git init
git add .
git commit -m "Initial commit: Web Kelurahan Notoharjo"

# Buat repo di GitHub, lalu:
git remote add origin https://github.com/<username>/web-notoharjo.git
git branch -M main
git push -u origin main
```

### Jika sudah ada repo:

```bash
git add vercel.json api/index.php
git commit -m "Add Vercel deployment config"
git push
```

> [!WARNING]
> Pastikan `.env` ada di `.gitignore` sebelum push. Periksa: `git status` jangan ada file `.env` terdaftar.

---

## 6. Import & Deploy di Vercel

1. Login ke [vercel.com](https://vercel.com)
2. Klik **Add New → Project**
3. Klik **Import Git Repository** → pilih `web-notoharjo`
4. Framework Preset: pilih **Other** (bukan Laravel — konfigurasi sudah di `vercel.json`)
5. Klik **Environment Variables** → tambahkan semua variabel dari [Langkah 4](#4-konfigurasi-environment-variables)
6. Klik **Deploy**

Vercel akan menjalankan build command dari `vercel.json`:

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> [!TIP]
> Build pertama bisa memakan waktu 3–5 menit karena install Composer & npm dari awal.

---

## 7. Jalankan Migrasi & Seeder

Vercel tidak mendukung perintah artisan secara langsung dari dashboard. Gunakan salah satu cara berikut:

### Cara A — Dari komputer lokal (Paling mudah)

Ubah sementara `.env` lokal Anda agar mengarah ke database cloud:

```dotenv
DB_HOST=<host_cloud>
DB_DATABASE=<nama_db_cloud>
DB_USERNAME=<user_cloud>
DB_PASSWORD=<pass_cloud>
```

Lalu jalankan:

```bash
php artisan migrate:fresh --seed
```

Kembalikan `.env` ke konfigurasi XAMPP lokal setelah selesai.

### Cara B — Vercel CLI

```bash
# Install Vercel CLI
npm install -g vercel

# Login
vercel login

# Jalankan artisan di environment Vercel
vercel env pull .env.vercel.local
php artisan migrate --force
php artisan db:seed --force
```

---

## 8. Upload Aset Gambar ke Storage Publik

Karena Vercel **tidak menyimpan file yang di-upload** oleh pengguna (filesystem tidak persisten), foto/gambar yang di-upload melalui form admin tidak akan tersimpan permanen.

### Solusi untuk Upload File

**Rekomendasi: Cloudinary (Gratis)**

1. Daftar di [cloudinary.com](https://cloudinary.com)
2. Tambahkan variabel env:
   ```dotenv
   CLOUDINARY_URL=cloudinary://<api_key>:<api_secret>@<cloud_name>
   ```
3. Install package: `composer require cloudinary-labs/cloudinary-laravel`
4. Ubah `FILESYSTEM_DISK=cloudinary` di `.env` Vercel

**Alternatif:** AWS S3, Backblaze B2, atau Supabase Storage.

### Aset Gambar Statis (sudah ada di `public/images/`)

Gambar statis yang sudah ter-commit di repo (foto kantor, pasar welit, dsb) akan tersedia langsung karena Vercel meng-serve folder `public/` sebagai static file. Tidak perlu konfigurasi tambahan.

---

## 9. Checklist Setelah Deploy

Setelah URL Vercel Anda aktif (contoh: `https://web-notoharjo.vercel.app`):

```
[ ] Halaman Beranda terbuka dan foto kantor tampil
[ ] Navigasi semua menu berfungsi
[ ] Login dengan akun demo (cetta@gmail.com / password) berhasil
[ ] Form ajukan surat bisa diisi dan dikirim
[ ] Admin dashboard terbuka (lurah@notoharjo.desa.id / password)
[ ] Halaman Pasar Welit dengan galeri foto tampil
[ ] Transparansi anggaran dan berita terbuka
[ ] Lacak surat dengan QR Code berfungsi
[ ] Session tidak hilang saat refresh halaman
```

---

## 10. Troubleshooting Umum

### ❌ Error: `Class 'PDO' not found`

Runtime PHP Vercel mungkin tidak include ekstensi PDO MySQL. Tambahkan ke `vercel.json`:

```json
"functions": {
    "api/index.php": {
        "runtime": "vercel-php@0.7.3",
        "environment": {
            "PHP_EXTENSIONS": "pdo pdo_mysql mbstring openssl tokenizer xml ctype json bcmath"
        }
    }
}
```

### ❌ Error: `No application encryption key has been specified`

`APP_KEY` belum di-set di Environment Variables Vercel. Jalankan `php artisan key:generate --show` di lokal dan tambahkan hasilnya.

### ❌ Error: `SQLSTATE: Access denied`

Periksa kredensial `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD` di dashboard Vercel. Pastikan IP Vercel diizinkan di whitelist firewall database cloud.

### ❌ Halaman blank / 500 setelah deploy

1. Buka **Vercel Dashboard → Functions → Logs**
2. Cari error PHP di log terbaru
3. Pastikan `APP_DEBUG=false` dan `LOG_CHANNEL=stderr`

### ❌ CSS/JS tidak muncul (Vite manifest not found)

Build Vite belum jalan atau gagal. Pastikan `npm run build` ada di `buildCommand` di `vercel.json` dan `package-lock.json` ter-commit di repo.

### ❌ Upload foto tidak tersimpan

Filesystem Vercel tidak persisten. Implementasikan Cloudinary atau S3 seperti di [Langkah 8](#8-upload-aset-gambar-ke-storage-publik).

---

## Referensi

- [Vercel PHP Runtime](https://github.com/vercel-community/php)
- [Laravel Deployment Documentation](https://laravel.com/docs/13.x/deployment)
- [PlanetScale Quick Start](https://planetscale.com/docs/tutorials/connect-laravel-app)
- [Cloudinary Laravel](https://github.com/cloudinary-community/cloudinary-laravel)

---

*Dibuat untuk: Web Kelurahan Notoharjo — Laravel 13 · PHP 8.3 · Tailwind CSS v4 · Vite 8*
