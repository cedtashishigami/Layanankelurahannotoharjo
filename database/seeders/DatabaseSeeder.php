<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\KartuKeluarga;
use App\Models\KodeSurat;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use App\Models\PotensiKelurahan;
use App\Models\SyaratSurat;
use App\Models\TransparansiAnggaran;
use App\Models\User;
use App\Models\WilayahDusun;
use App\Models\WilayahRt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Wilayah Dusun (Berdasarkan Sejarah Bedeng Notoharjo 1937)
        $dusun1 = WilayahDusun::create([
            'nama_dusun' => 'Dusun I - Bedeng 17 Polos (Nambah Rejo)',
            'nama_kadus' => 'Tafsirudin',
            'kontak_kadus' => '081234567001',
            'keterangan' => 'Pusat pemerintahan kelurahan Notoharjo dan kantor balai desa.',
        ]);

        $dusun2 = WilayahDusun::create([
            'nama_dusun' => 'Dusun II - Bedeng 17A (Nunggal Rejo)',
            'nama_kadus' => 'Dwi Jo Wahono',
            'kontak_kadus' => '081234567002',
            'keterangan' => 'Sentra pertanian pangan dan persawahan produktif.',
        ]);

        $dusun3 = WilayahDusun::create([
            'nama_dusun' => 'Dusun III - Bedeng 18 Polos (Mengger Rejo / Pasar Welit)',
            'nama_kadus' => 'Purnomo',
            'kontak_kadus' => '081234567003',
            'keterangan' => 'Pusat perdagangan masyarakat dan lokasi Pasar Tradisional Welit.',
        ]);

        // 2. Wilayah RT & RW
        $rt1 = WilayahRt::create([
            'id_dusun' => $dusun1->id_dusun,
            'nomor_rt' => '001',
            'nomor_rw' => '001',
            'nama_ketua_rt' => 'Slamet Riyadi',
            'kontak_rt' => '085234567101',
        ]);

        $rt2 = WilayahRt::create([
            'id_dusun' => $dusun1->id_dusun,
            'nomor_rt' => '002',
            'nomor_rw' => '001',
            'nama_ketua_rt' => 'Sugeng Prayitno',
            'kontak_rt' => '085234567102',
        ]);

        $rt3 = WilayahRt::create([
            'id_dusun' => $dusun1->id_dusun,
            'nomor_rt' => '003',
            'nomor_rw' => '002',
            'nama_ketua_rt' => 'Budi Santoso',
            'kontak_rt' => '085234567103',
        ]);

        $rt4 = WilayahRt::create([
            'id_dusun' => $dusun2->id_dusun,
            'nomor_rt' => '004',
            'nomor_rw' => '002',
            'nama_ketua_rt' => 'Wahyudi',
            'kontak_rt' => '085234567104',
        ]);

        // 3. Master Pendidikan
        $pends = [
            'Tidak / Belum Sekolah',
            'SD / Sederajat',
            'SMP / Sederajat',
            'SMA / Sederajat',
            'Diploma (D1 - D3)',
            'Sarjana (S1)',
            'Magister (S2)',
            'Doktor (S3)',
        ];
        $pendMap = [];
        foreach ($pends as $p) {
            $pendMap[$p] = Pendidikan::create(['nama_pendidikan' => $p])->id_pendidikan;
        }

        // 4. Master Pekerjaan
        $peks = [
            'Petani / Pekebun',
            'Pedagang',
            'Wiraswasta',
            'Pegawai Negeri Sipil (PNS)',
            'Guru / Dosen',
            'Karyawan Swasta',
            'Buruh Harian Lepas',
            'Ibu Rumah Tangga',
            'Pelajar / Mahasiswa',
            'Belum / Tidak Bekerja',
            'Tenaga Medis / Bidan',
        ];
        $pekMap = [];
        foreach ($peks as $pk) {
            $pekMap[$pk] = Pekerjaan::create(['nama_pekerjaan' => $pk])->id_pekerjaan;
        }

        // 5. Kartu Keluarga & Penduduk (Warga Notoharjo Asli)
        $kk1 = KartuKeluarga::create([
            'id_rt' => $rt1->id_rt,
            'nomor_kk' => '1802010101010001',
            'nama_kepala_keluarga' => 'Bambang Sungkowo',
            'alamat_lengkap' => 'Jl. Veteran No. 12, RT 001 / RW 001, Dusun 17 Polos, Kelurahan Notoharjo',
            'kode_pos' => '34172',
        ]);

        $pendLurah = Penduduk::create([
            'id_kartu_keluarga' => $kk1->id_kartu_keluarga,
            'id_pekerjaan' => $pekMap['Pegawai Negeri Sipil (PNS)'],
            'id_pendidikan' => $pendMap['Sarjana (S1)'],
            'nik' => '1802011005720001',
            'nama_lengkap' => 'Bambang Sungkowo',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Lampung Tengah',
            'tanggal_lahir' => '1972-05-10',
            'agama' => 'Islam',
            'status_kawin' => 'Menikah',
            'status_hubungan_keluarga' => 'Kepala Keluarga',
            'kewarganegaraan' => 'WNI',
            'nama_ayah' => 'Karto Suwiryo',
            'nama_ibu' => 'Siti Aminah',
            'no_telepon' => '081278901234',
            'status_keberadaan' => 'Aktif',
        ]);

        $kk2 = KartuKeluarga::create([
            'id_rt' => $rt3->id_rt,
            'nomor_kk' => '1802050304120009',
            'nama_kepala_keluarga' => 'HERI KURNIAWAN JATI',
            'alamat_lengkap' => 'Dusun I, RT 003 / RW 002, Kelurahan Notoharjo, Kec. Trimurjo',
            'kode_pos' => '34172',
        ]);

        $pendHeri = Penduduk::create([
            'id_kartu_keluarga' => $kk2->id_kartu_keluarga,
            'id_pekerjaan' => $pekMap['Wiraswasta'],
            'id_pendidikan' => $pendMap['Diploma (D1 - D3)'],
            'nik' => '1802052601720003',
            'nama_lengkap' => 'Heri Kurniawan Jati',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Metro',
            'tanggal_lahir' => '1972-01-26',
            'agama' => 'Islam',
            'status_kawin' => 'Menikah',
            'status_hubungan_keluarga' => 'Kepala Keluarga',
            'kewarganegaraan' => 'WNI',
            'nama_ayah' => 'Sukiyatno',
            'nama_ibu' => 'Daliyah',
            'no_telepon' => '082188990010',
            'status_keberadaan' => 'Aktif',
        ]);

        $pendHenny = Penduduk::create([
            'id_kartu_keluarga' => $kk2->id_kartu_keluarga,
            'id_pekerjaan' => $pekMap['Tenaga Medis / Bidan'] ?? $pekMap['Wiraswasta'],
            'id_pendidikan' => $pendMap['Diploma (D1 - D3)'],
            'nik' => '1802055606740004',
            'nama_lengkap' => 'Henny Kurniawati',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Metro',
            'tanggal_lahir' => '1974-06-16',
            'agama' => 'Islam',
            'status_kawin' => 'Menikah',
            'status_hubungan_keluarga' => 'Istri',
            'kewarganegaraan' => 'WNI',
            'nama_ayah' => 'T Ismail',
            'nama_ibu' => 'Sumarni',
            'no_telepon' => '082188990011',
            'status_keberadaan' => 'Aktif',
        ]);

        $pendBilla = Penduduk::create([
            'id_kartu_keluarga' => $kk2->id_kartu_keluarga,
            'id_pekerjaan' => $pekMap['Pelajar / Mahasiswa'],
            'id_pendidikan' => $pendMap['SMA / Sederajat'],
            'nik' => '1802052209000005',
            'nama_lengkap' => 'Billa Fajar Kurnia',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Notoharjo',
            'tanggal_lahir' => '2000-09-22',
            'agama' => 'Islam',
            'status_kawin' => 'Belum Menikah',
            'status_hubungan_keluarga' => 'Anak',
            'kewarganegaraan' => 'WNI',
            'nama_ayah' => 'Heri Kurniawan Jati',
            'nama_ibu' => 'Henny Kurniawati',
            'no_telepon' => '082188990012',
            'status_keberadaan' => 'Aktif',
        ]);

        $pendCetta = Penduduk::create([
            'id_kartu_keluarga' => $kk2->id_kartu_keluarga,
            'id_pekerjaan' => $pekMap['Pelajar / Mahasiswa'],
            'id_pendidikan' => $pendMap['SMA / Sederajat'],
            'nik' => '1802050207060006',
            'nama_lengkap' => 'Cetta Nafis Kurnia',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Untoro',
            'tanggal_lahir' => '2006-07-02',
            'agama' => 'Islam',
            'status_kawin' => 'Belum Menikah',
            'status_hubungan_keluarga' => 'Anak',
            'kewarganegaraan' => 'WNI',
            'nama_ayah' => 'Heri Kurniawan Jati',
            'nama_ibu' => 'Henny Kurniawati',
            'no_telepon' => '082188990013',
            'status_keberadaan' => 'Aktif',
        ]);

        $pendNala = Penduduk::create([
            'id_kartu_keluarga' => $kk2->id_kartu_keluarga,
            'id_pekerjaan' => $pekMap['Belum / Tidak Bekerja'],
            'id_pendidikan' => $pendMap['SD / Sederajat'],
            'nik' => '1802050412130001',
            'nama_lengkap' => 'Nala Nathan Kurnia',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Metro',
            'tanggal_lahir' => '2013-12-04',
            'agama' => 'Islam',
            'status_kawin' => 'Belum Menikah',
            'status_hubungan_keluarga' => 'Anak',
            'kewarganegaraan' => 'WNI',
            'nama_ayah' => 'Heri Kurniawan Jati',
            'nama_ibu' => 'Henny Kurniawati',
            'no_telepon' => '082188990014',
            'status_keberadaan' => 'Aktif',
        ]);

        // 6. Users / Akun (Admin, Pegawai Kelurahan & Warga)
        $admin = User::create([
            'name' => 'Administrator Notoharjo',
            'email' => 'admin@notoharjo.desa.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'jabatan' => 'Pranata Komputer / IT Support',
            'no_hp' => '081112223344',
            'is_active' => true,
        ]);

        $lurah = User::create([
            'id_penduduk' => $pendLurah->id_penduduk,
            'id_dusun' => $dusun1->id_dusun,
            'name' => 'Bambang Sungkowo',
            'email' => 'lurah@notoharjo.desa.id',
            'nik' => $pendLurah->nik,
            'password' => Hash::make('password'),
            'role' => 'lurah',
            'jabatan' => 'Kepala Kelurahan (Lurah)',
            'no_hp' => '081278901234',
            'is_active' => true,
        ]);

        $sekretaris = User::create([
            'name' => 'Muhammad Mahfud, S.Pd.I',
            'email' => 'sekretaris@notoharjo.desa.id',
            'password' => Hash::make('password'),
            'role' => 'sekretaris',
            'jabatan' => 'Sekretaris Kelurahan',
            'no_hp' => '081278901235',
            'is_active' => true,
        ]);

        $kasiPelayanan = User::create([
            'name' => 'Karni Hanani, S.E',
            'email' => 'pelayanan@notoharjo.desa.id',
            'password' => Hash::make('password'),
            'role' => 'kasi_pelayanan',
            'jabatan' => 'Kepala Seksi Pelayanan',
            'no_hp' => '081278901236',
            'is_active' => true,
        ]);

        $kasiPemerintahan = User::create([
            'name' => 'Suparmin, S.E',
            'email' => 'pemerintahan@notoharjo.desa.id',
            'password' => Hash::make('password'),
            'role' => 'kasi_pemerintahan',
            'jabatan' => 'Kepala Seksi Pemerintahan',
            'no_hp' => '081278901237',
            'is_active' => true,
        ]);

        $kadus3 = User::create([
            'id_dusun' => $dusun3->id_dusun,
            'name' => 'Purnomo (Kadus III)',
            'email' => 'kadus3@notoharjo.desa.id',
            'password' => Hash::make('password'),
            'role' => 'kadus',
            'jabatan' => 'Kepala Dusun 18 Polos',
            'no_hp' => '081234567003',
            'is_active' => true,
        ]);

        $userWarga = User::create([
            'id_penduduk' => $pendCetta->id_penduduk,
            'id_dusun' => $dusun1->id_dusun,
            'name' => 'Cetta Nafis Kurnia',
            'email' => 'cetta@gmail.com',
            'nik' => $pendCetta->nik,
            'password' => Hash::make('password'),
            'role' => 'warga',
            'no_hp' => '082188990013',
            'is_active' => true,
        ]);

        // 7. Master Kode Surat & Syarat Surat
        $suratSku = KodeSurat::create([
            'kode_klasifikasi' => '503',
            'nama_surat' => 'Surat Keterangan Usaha (SKU)',
            'template_view' => 'surat.sku',
            'masa_berlaku_hari' => 30,
            'deskripsi' => 'Surat keterangan kepemilikan dan legalitas tempat usaha untuk keperluan pinjaman bank/KUR atau legalitas perdagangan.',
        ]);

        SyaratSurat::create([
            'id_kode_surat' => $suratSku->id_kode_surat,
            'nama_syarat' => 'Scan / Foto Kartu Tanda Penduduk (KTP)',
            'is_wajib' => true,
            'keterangan' => 'Format JPG/PNG/PDF maks 2MB',
        ]);
        SyaratSurat::create([
            'id_kode_surat' => $suratSku->id_kode_surat,
            'nama_syarat' => 'Scan / Foto Kartu Keluarga (KK)',
            'is_wajib' => true,
            'keterangan' => 'Format JPG/PNG/PDF maks 2MB',
        ]);
        SyaratSurat::create([
            'id_kode_surat' => $suratSku->id_kode_surat,
            'nama_syarat' => 'Foto Tempat / Kegiatan Usaha',
            'is_wajib' => true,
            'keterangan' => 'Foto fisik kios / warung / lahan pertanian',
        ]);

        $suratDomisili = KodeSurat::create([
            'kode_klasifikasi' => '470',
            'nama_surat' => 'Surat Keterangan Domisili',
            'template_view' => 'surat.domisili',
            'masa_berlaku_hari' => 60,
            'deskripsi' => 'Surat bukti tempat tinggal sah warga di lingkungan Kelurahan Notoharjo.',
        ]);

        SyaratSurat::create([
            'id_kode_surat' => $suratDomisili->id_kode_surat,
            'nama_syarat' => 'Scan / Foto KTP',
            'is_wajib' => true,
        ]);
        SyaratSurat::create([
            'id_kode_surat' => $suratDomisili->id_kode_surat,
            'nama_syarat' => 'Scan / Foto Kartu Keluarga',
            'is_wajib' => true,
        ]);
        SyaratSurat::create([
            'id_kode_surat' => $suratDomisili->id_kode_surat,
            'nama_syarat' => 'Surat Pengantar RT / Kadus Setempat',
            'is_wajib' => true,
        ]);

        $suratSkck = KodeSurat::create([
            'kode_klasifikasi' => '331',
            'nama_surat' => 'Surat Pengantar SKCK',
            'template_view' => 'surat.skck',
            'masa_berlaku_hari' => 30,
            'deskripsi' => 'Pengantar pengurusan Surat Keterangan Catatan Kepolisian ke Polsek Trimurjo / Polres Lampung Tengah.',
        ]);

        SyaratSurat::create([
            'id_kode_surat' => $suratSkck->id_kode_surat,
            'nama_syarat' => 'Scan / Foto KTP & KK',
            'is_wajib' => true,
        ]);
        SyaratSurat::create([
            'id_kode_surat' => $suratSkck->id_kode_surat,
            'nama_syarat' => 'Surat Pengantar RT Setempat',
            'is_wajib' => true,
        ]);

        $suratSktm = KodeSurat::create([
            'kode_klasifikasi' => '401',
            'nama_surat' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'template_view' => 'surat.sktm',
            'masa_berlaku_hari' => 90,
            'deskripsi' => 'Surat permohonan keringanan biaya pendidikan/sekolah, rumah sakit/BPJS PBI, dan bantuan sosial.',
        ]);

        SyaratSurat::create([
            'id_kode_surat' => $suratSktm->id_kode_surat,
            'nama_syarat' => 'Scan KTP & Kartu Keluarga',
            'is_wajib' => true,
        ]);
        SyaratSurat::create([
            'id_kode_surat' => $suratSktm->id_kode_surat,
            'nama_syarat' => 'Surat Pernyataan Tidak Mampu dari RT',
            'is_wajib' => true,
        ]);

        // 8. Potensi Kelurahan (Merujuk Rozi & Listiawan 2017 & Profil Naskah)
        PotensiKelurahan::create([
            'id_dusun' => $dusun3->id_dusun,
            'id_user' => $admin->id_user,
            'nama_potensi' => 'Pasar Tradisional Welit (Desa 18 Polos)',
            'kategori' => 'Pasar Tradisional / Perdagangan',
            'pemilik' => 'Pemerintah Kelurahan & Paguyuban Pedagang',
            'deskripsi' => 'Pasar bersejarah yang berdiri sejak awal pembukaan lahan kolonisasi 1937, dinamai dari atap ilalang (Welit). Menjadi denyut nadi ekonomi perdagangan dan sentra sayur mayur se-Kecamatan Trimurjo.',
            'kontak' => '081234567003',
            'lokasi' => 'Bedeng 18 Polos (Mengger Rejo), Kelurahan Notoharjo',
        ]);

        PotensiKelurahan::create([
            'id_dusun' => $dusun2->id_dusun,
            'id_user' => $admin->id_user,
            'nama_potensi' => 'Sentra Lumbung Padi & Jagung Trimurjo',
            'kategori' => 'Pertanian',
            'pemilik' => 'Gapoktan Subur Makmur Notoharjo',
            'deskripsi' => 'Dengan lebih dari 60% warga berprofesi sebagai petani dan luas lahan persawahan irigasi teknis mencapai ratusan hektar, Notoharjo merupakan produsen pangan utama di Trimurjo Lampung Tengah.',
            'kontak' => '082188990011',
            'lokasi' => 'Persawahan Bedeng 17A (Nunggal Rejo), Notoharjo',
        ]);

        PotensiKelurahan::create([
            'id_dusun' => $dusun1->id_dusun,
            'id_user' => $admin->id_user,
            'nama_potensi' => 'UMKM Keripik Pisang & Olahan Singkong Notoharjo',
            'kategori' => 'UMKM & Industri Rumahan',
            'pemilik' => 'Kelompok Wanita Tani (KWT) Melati',
            'deskripsi' => 'Produksi aneka camilan khas olahan hasil bumi Notoharjo dengan cita rasa renyah, telah dipasarkan ke Metro, Bandar Lampung, hingga luar pulau.',
            'kontak' => '081399887766',
            'lokasi' => 'Jl. Kenanga No. 8, Dusun I (17 Polos), Notoharjo',
        ]);

        // 9. Transparansi Anggaran (Publikasi APBD / Dana Kelurahan 2026)
        TransparansiAnggaran::create([
            'id_user' => $admin->id_user,
            'tahun_anggaran' => 2026,
            'jenis' => 'Pendapatan',
            'bidang' => 'Dana Alokasi Umum & APBD Kabupaten',
            'uraian' => 'Pagu Anggaran Dana Kelurahan Notoharjo TA 2026',
            'target_anggaran' => 850000000,
            'realisasi_anggaran' => 850000000,
            'keterangan' => 'Pencairan 100% dari APBD Kabupaten Lampung Tengah',
        ]);

        TransparansiAnggaran::create([
            'id_user' => $admin->id_user,
            'tahun_anggaran' => 2026,
            'jenis' => 'Belanja',
            'bidang' => 'Pelaksanaan Pembangunan Kelurahan',
            'uraian' => 'Pembangunan Rabat Beton Jalan Usaha Tani Dusun II & III',
            'target_anggaran' => 380000000,
            'realisasi_anggaran' => 378500000,
            'keterangan' => 'Selesai pengerjaan sepanjang 1.200 meter',
        ]);

        TransparansiAnggaran::create([
            'id_user' => $admin->id_user,
            'tahun_anggaran' => 2026,
            'jenis' => 'Belanja',
            'bidang' => 'Penyelenggaraan Pemerintahan',
            'uraian' => 'Digitalisasi Pelayanan Surat & Pengadaan Komputer Balai Desa',
            'target_anggaran' => 125000000,
            'realisasi_anggaran' => 124200000,
            'keterangan' => 'Website pelayanan administrasi dan sistem informasi kelurahan',
        ]);

        TransparansiAnggaran::create([
            'id_user' => $admin->id_user,
            'tahun_anggaran' => 2026,
            'jenis' => 'Belanja',
            'bidang' => 'Pembinaan & Pemberdayaan Masyarakat',
            'uraian' => 'Program Posyandu Lansia, Bantuan Pangan Stunting & Pelatihan Gapoktan',
            'target_anggaran' => 195000000,
            'realisasi_anggaran' => 189000000,
            'keterangan' => 'Kegiatan rutin bulanan di 3 dusun',
        ]);

        // 10. Berita & Informasi Publik
        Berita::create([
            'id_user' => $admin->id_user,
            'judul' => 'Sejarah Singkat Kelurahan Notoharjo: Dari Kolonisasi 1937 Hingga Era Digital',
            'slug' => 'sejarah-singkat-kelurahan-notoharjo',
            'ringkasan' => 'Mengenal perjalanan panjang berdirinya Kelurahan Notoharjo dari pembukaan hutan belantara bedeng 17 dan 18 hingga kemajuan saat ini.',
            'isi_berita' => '<p>Kelurahan Notoharjo semula merupakan hutan belantara yang dibuka pada masa penjajahan Belanda melalui program kolonisasi (transmigrasi) pada tahun 1936-1937. Para penduduk awal didatangkan dari Jawa Tengah dan Jawa Timur yang ditempatkan sementara di Pringsewu sebelum diberangkatkan ke kawasan hutan yang kini menjadi Notoharjo.</p><p>Kawasan ini mulanya terbagi dalam tiga bedeng penampungan: Bedeng 17 Polos (Nambah Rejo), Bedeng 17A (Nunggal Rejo), dan Bedeng 18 Polos (Mengger Rejo/Pasar Welit) dengan luas wilayah mencapai 477,25 Ha serta lahan pertanian seluas 317,43 Ha. Kini di bawah kepemimpinan Kelurahan Notoharjo, transformasi digital dimulai untuk mempercepat pelayanan masyarakat.</p>',
            'gambar' => 'images/berita/berita-sejarah.jpg',
            'status' => 'published',
            'views' => 120,
        ]);

        Berita::create([
            'id_user' => $admin->id_user,
            'judul' => 'Peluncuran Website Resmi dan Sistem Informasi Administrasi Kelurahan Notoharjo',
            'slug' => 'peluncuran-website-resmi-kelurahan-notoharjo',
            'ringkasan' => 'Pemerintah Kelurahan Notoharjo kini menyediakan layanan surat-menyurat online mandiri yang dapat diakses warga dari rumah.',
            'isi_berita' => '<p>Untuk mengatasi antrean dan keterlambatan pengurusan surat fisik, Pemerintah Kelurahan Notoharjo resmi meluncurkan portal sistem informasi terpadu. Warga dapat mengajukan Surat Keterangan Usaha, Domisili, dan Pengantar SKCK secara online dan memantau status secara langsung tanpa harus menunggu lama di kantor desa.</p>',
            'gambar' => 'images/berita/berita-digital.jpg',
            'status' => 'published',
            'views' => 95,
        ]);

        Berita::create([
            'id_user' => $admin->id_user,
            'judul' => 'Optimalisasi Saluran Irigasi Teknis dan Pendampingan Kelompok Tani Notoharjo',
            'slug' => 'optimalisasi-saluran-irigasi-teknis-kelompok-tani-notoharjo',
            'ringkasan' => 'Dinas Pertanian bersama Kelurahan Notoharjo menggelar peninjauan pintu air dan pembinaan gabungan kelompok tani guna mengantisipasi musim tanam.',
            'isi_berita' => '<p>Guna menjamin ketersediaan pasokan air bagi ratusan hektar areal persawahan di Bedeng 17 dan 17A, Pemerintah Kelurahan Notoharjo bersama Gapoktan Subur Makmur melakukan peninjauan intensif di sepanjang jalur saluran irigasi sekunder.</p><p>Langkah ini dilakukan untuk memastikan debit air merata ke seluruh petak sawah petani Notoharjo demi mempertahankan status Trimurjo sebagai salah satu lumbung pangan utama Kabupaten Lampung Tengah.</p>',
            'gambar' => 'images/berita/berita-pertanian.jpg',
            'status' => 'published',
            'views' => 84,
        ]);

        // 11. Agenda Kegiatan
        Agenda::create([
            'id_user' => $admin->id_user,
            'nama_kegiatan' => 'Musyawarah Perencanaan Pembangunan (Musrenbang) Kelurahan',
            'deskripsi' => 'Pembahasan usulan prioritas pembangunan infrastruktur pertanian dan fasilitas umum tahun anggaran mendatang.',
            'lokasi' => 'Balai Pertemuan Kelurahan Notoharjo',
            'tanggal_mulai' => now()->addDays(5)->setTime(9, 0),
            'tanggal_selesai' => now()->addDays(5)->setTime(13, 0),
            'penyelenggara' => 'Lurah & BPK Kelurahan Notoharjo',
        ]);

        Agenda::create([
            'id_user' => $admin->id_user,
            'nama_kegiatan' => 'Posyandu Balita & Pemeriksaan Kesehatan Lansia Gratis',
            'deskripsi' => 'Layanan imunisasi anak, penimbangan balita, dan cek tensi/gula darah gratis untuk lansia di Bedeng 18 Polos.',
            'lokasi' => 'Poskesdes Dusun III (Pasar Welit)',
            'tanggal_mulai' => now()->addDays(10)->setTime(8, 30),
            'tanggal_selesai' => now()->addDays(10)->setTime(11, 30),
            'penyelenggara' => 'Kader PKK & Bidan Desa',
        ]);

        // 12. Galeri Foto & Dokumentasi
        Galeri::create([
            'id_user' => $admin->id_user,
            'judul' => 'Kegiatan Gotong Royong Pembersihan Saluran Irigasi Persawahan Notoharjo',
            'file_media' => 'images/galeri/galeri-gotong-royong.jpg',
            'jenis_media' => 'foto',
            'keterangan' => 'Partisipasi para petani dan aparat desa merawat saluran pengairan tanaman padi.',
        ]);

        Galeri::create([
            'id_user' => $admin->id_user,
            'judul' => 'Suasana Pasar Tradisional Welit Menjelang Pagi',
            'file_media' => 'images/galeri/galeri-pasar-welit.jpg',
            'jenis_media' => 'foto',
            'keterangan' => 'Aktivitas jual beli hasil bumi sayur mayur dan pangan di Pasar Welit.',
        ]);

        Galeri::create([
            'id_user' => $admin->id_user,
            'judul' => 'Panen Raya Padi Petani Notoharjo di Hamparan Persawahan Bedeng 17',
            'file_media' => 'images/galeri/galeri-panen.jpg',
            'jenis_media' => 'foto',
            'keterangan' => 'Musim panen padi hasil irigasi teknis oleh para petani Gapoktan Subur Makmur Notoharjo.',
        ]);

        Galeri::create([
            'id_user' => $admin->id_user,
            'judul' => 'Penyerahan Akun Operator & Peluncuran Website Kelurahan Notoharjo',
            'file_media' => 'images/berita/berita-digital.jpg',
            'jenis_media' => 'foto',
            'keterangan' => 'Pelaksanaan program pengabdian kepada masyarakat (PKM) Universitas Muhammadiyah Metro bersama jajaran aparat Kelurahan Notoharjo.',
        ]);

        Galeri::create([
            'id_user' => $admin->id_user,
            'judul' => 'Pemeriksaan Kesehatan Berkala Posyandu Balita & Lansia Dusun II',
            'file_media' => 'images/galeri/galeri-posyandu.jpg',
            'jenis_media' => 'foto',
            'keterangan' => 'Kegiatan rutin kader posyandu bersama tenaga medis puskesmas pembantu Trimurjo.',
        ]);

        Galeri::create([
            'id_user' => $admin->id_user,
            'judul' => 'Rapat Koordinasi Aparatur Kelurahan & Musrenbang Notoharjo',
            'file_media' => 'images/galeri/galeri-musrenbang.jpg',
            'jenis_media' => 'foto',
            'keterangan' => 'Musyawarah perencanaan pembangunan dan evaluasi program kerja aparat kelurahan Notoharjo.',
        ]);

        $this->call(TambahanPendudukSeeder::class);
    }
}
