<?php

namespace Database\Seeders;

use App\Models\KartuKeluarga;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use Illuminate\Database\Seeder;

class TambahanPendudukSeeder extends Seeder
{
    public function run(): void
    {
        $pekMap = Pekerjaan::pluck('id_pekerjaan', 'nama_pekerjaan');
        $pendMap = Pendidikan::pluck('id_pendidikan', 'nama_pendidikan');

        // KK 3: Keluarga Suparno Hadi (Dusun I - Bedeng 17 Polos, RT 002)
        $kk3 = KartuKeluarga::firstOrCreate(
            ['nomor_kk' => '1802010303030003'],
            [
                'id_rt' => 2,
                'nama_kepala_keluarga' => 'Suparno Hadi',
                'alamat_lengkap' => 'Jl. Veteran No. 28, RT 002 / RW 001, Dusun 17 Polos, Kelurahan Notoharjo',
                'kode_pos' => '34172',
            ]
        );

        // 1. Suparno Hadi
        Penduduk::firstOrCreate(
            ['nik' => '1802011204680005'],
            [
                'id_kartu_keluarga' => $kk3->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Petani / Pekebun'] ?? 1,
                'id_pendidikan' => $pendMap['SMA / Sederajat'] ?? 4,
                'nama_lengkap' => 'Suparno Hadi',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Lampung Tengah',
                'tanggal_lahir' => '1968-04-12',
                'agama' => 'Islam',
                'status_kawin' => 'Menikah',
                'status_hubungan_keluarga' => 'Kepala Keluarga',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Kromo Rejo',
                'nama_ibu' => 'Sariyem',
                'no_telepon' => '081369112233',
                'status_keberadaan' => 'Aktif',
            ]
        );

        // 2. Sri Wahyuni
        Penduduk::firstOrCreate(
            ['nik' => '1802012509720006'],
            [
                'id_kartu_keluarga' => $kk3->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Ibu Rumah Tangga'] ?? 8,
                'id_pendidikan' => $pendMap['SMP / Sederajat'] ?? 3,
                'nama_lengkap' => 'Sri Wahyuni',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Trimurjo',
                'tanggal_lahir' => '1972-09-25',
                'agama' => 'Islam',
                'status_kawin' => 'Menikah',
                'status_hubungan_keluarga' => 'Istri',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Sastro Wiyono',
                'nama_ibu' => 'Paini',
                'no_telepon' => '081369112234',
                'status_keberadaan' => 'Aktif',
            ]
        );

        // 3. Bayu Setiawan
        Penduduk::firstOrCreate(
            ['nik' => '1802011406020007'],
            [
                'id_kartu_keluarga' => $kk3->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Pelajar / Mahasiswa'] ?? 9,
                'id_pendidikan' => $pendMap['SMA / Sederajat'] ?? 4,
                'nama_lengkap' => 'Bayu Setiawan',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Notoharjo',
                'tanggal_lahir' => '2002-06-14',
                'agama' => 'Islam',
                'status_kawin' => 'Belum Menikah',
                'status_hubungan_keluarga' => 'Anak',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Suparno Hadi',
                'nama_ibu' => 'Sri Wahyuni',
                'no_telepon' => '081369112235',
                'status_keberadaan' => 'Aktif',
            ]
        );

        // KK 4: Keluarga Hendra Kusuma (Dusun II - Bedeng 17A, RT 003)
        $kk4 = KartuKeluarga::firstOrCreate(
            ['nomor_kk' => '1802010404040004'],
            [
                'id_rt' => 3,
                'nama_kepala_keluarga' => 'Hendra Kusuma, S.T.',
                'alamat_lengkap' => 'Jl. Irigasi Bedeng 17A No. 15, RT 003 / RW 002, Kelurahan Notoharjo',
                'kode_pos' => '34172',
            ]
        );

        // 4. Hendra Kusuma
        Penduduk::firstOrCreate(
            ['nik' => '1802011802800008'],
            [
                'id_kartu_keluarga' => $kk4->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Wiraswasta'] ?? 3,
                'id_pendidikan' => $pendMap['Sarjana (S1)'] ?? 6,
                'nama_lengkap' => 'Hendra Kusuma, S.T.',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Metro',
                'tanggal_lahir' => '1980-02-18',
                'agama' => 'Islam',
                'status_kawin' => 'Menikah',
                'status_hubungan_keluarga' => 'Kepala Keluarga',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Mulyono',
                'nama_ibu' => 'Sulastri',
                'no_telepon' => '085273114455',
                'status_keberadaan' => 'Aktif',
            ]
        );

        // 5. Dewi Lestari
        Penduduk::firstOrCreate(
            ['nik' => '1802010911830009'],
            [
                'id_kartu_keluarga' => $kk4->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Guru / Dosen'] ?? 5,
                'id_pendidikan' => $pendMap['Sarjana (S1)'] ?? 6,
                'nama_lengkap' => 'Dewi Lestari, S.Pd.',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Trimurjo',
                'tanggal_lahir' => '1983-11-09',
                'agama' => 'Islam',
                'status_kawin' => 'Menikah',
                'status_hubungan_keluarga' => 'Istri',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Suwarto',
                'nama_ibu' => 'Warsiti',
                'no_telepon' => '085273114456',
                'status_keberadaan' => 'Aktif',
            ]
        );

        // 6. Anisa Rahmadani
        Penduduk::firstOrCreate(
            ['nik' => '1802012108100010'],
            [
                'id_kartu_keluarga' => $kk4->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Pelajar / Mahasiswa'] ?? 9,
                'id_pendidikan' => $pendMap['SMP / Sederajat'] ?? 3,
                'nama_lengkap' => 'Anisa Rahmadani',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Notoharjo',
                'tanggal_lahir' => '2010-08-21',
                'agama' => 'Islam',
                'status_kawin' => 'Belum Menikah',
                'status_hubungan_keluarga' => 'Anak',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Hendra Kusuma',
                'nama_ibu' => 'Dewi Lestari',
                'no_telepon' => '085273114457',
                'status_keberadaan' => 'Aktif',
            ]
        );

        // KK 5: Keluarga Slamet Riyadi (Dusun III - Bedeng 18 Polos Pasar Welit, RT 004)
        $kk5 = KartuKeluarga::firstOrCreate(
            ['nomor_kk' => '1802010505050005'],
            [
                'id_rt' => 4,
                'nama_kepala_keluarga' => 'Slamet Riyadi',
                'alamat_lengkap' => 'Kawasan Pasar Welit No. 04, RT 004 / RW 002, Bedeng 18, Kelurahan Notoharjo',
                'kode_pos' => '34172',
            ]
        );

        // 7. Slamet Riyadi
        Penduduk::firstOrCreate(
            ['nik' => '1802010305750011'],
            [
                'id_kartu_keluarga' => $kk5->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Pedagang'] ?? 2,
                'id_pendidikan' => $pendMap['SMA / Sederajat'] ?? 4,
                'nama_lengkap' => 'Slamet Riyadi',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Lampung Tengah',
                'tanggal_lahir' => '1975-05-03',
                'agama' => 'Islam',
                'status_kawin' => 'Menikah',
                'status_hubungan_keluarga' => 'Kepala Keluarga',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Marto Sudarmo',
                'nama_ibu' => 'Tukiyem',
                'no_telepon' => '082281997788',
                'status_keberadaan' => 'Aktif',
            ]
        );

        // 8. Partini
        Penduduk::firstOrCreate(
            ['nik' => '1802011707790012'],
            [
                'id_kartu_keluarga' => $kk5->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Pedagang'] ?? 2,
                'id_pendidikan' => $pendMap['SMP / Sederajat'] ?? 3,
                'nama_lengkap' => 'Partini',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Notoharjo',
                'tanggal_lahir' => '1979-07-17',
                'agama' => 'Islam',
                'status_kawin' => 'Menikah',
                'status_hubungan_keluarga' => 'Istri',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Djoyo Sukarto',
                'nama_ibu' => 'Supatmi',
                'no_telepon' => '082281997789',
                'status_keberadaan' => 'Aktif',
            ]
        );

        // 9. Dimas Prasetyo
        Penduduk::firstOrCreate(
            ['nik' => '1802012912000013'],
            [
                'id_kartu_keluarga' => $kk5->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Karyawan Swasta'] ?? 6,
                'id_pendidikan' => $pendMap['SMA / Sederajat'] ?? 4,
                'nama_lengkap' => 'Dimas Prasetyo',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Notoharjo',
                'tanggal_lahir' => '2000-12-29',
                'agama' => 'Islam',
                'status_kawin' => 'Belum Menikah',
                'status_hubungan_keluarga' => 'Anak',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Slamet Riyadi',
                'nama_ibu' => 'Partini',
                'no_telepon' => '082281997790',
                'status_keberadaan' => 'Aktif',
            ]
        );

        // KK 6: Tokoh Sesepuh Mbah Karyo Utomo (Dusun I - Bedeng 17 Polos, RT 001)
        $kk6 = KartuKeluarga::firstOrCreate(
            ['nomor_kk' => '1802010606060006'],
            [
                'id_rt' => 1,
                'nama_kepala_keluarga' => 'Karyo Utomo',
                'alamat_lengkap' => 'Jl. Perintis Kemerdekaan No. 02, RT 001 / RW 001, Bedeng 17 Polos, Kelurahan Notoharjo',
                'kode_pos' => '34172',
            ]
        );

        // 10. Karyo Utomo
        Penduduk::firstOrCreate(
            ['nik' => '1802010107500014'],
            [
                'id_kartu_keluarga' => $kk6->id_kartu_keluarga,
                'id_pekerjaan' => $pekMap['Petani / Pekebun'] ?? 1,
                'id_pendidikan' => $pendMap['SD / Sederajat'] ?? 2,
                'nama_lengkap' => 'Karyo Utomo',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Kebumen (Jawa Tengah)',
                'tanggal_lahir' => '1950-07-01',
                'agama' => 'Islam',
                'status_kawin' => 'Duda / Cerai Mati',
                'status_hubungan_keluarga' => 'Kepala Keluarga',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Harjo Pawiro',
                'nama_ibu' => 'Rubiyem',
                'no_telepon' => '081299887766',
                'status_keberadaan' => 'Aktif',
            ]
        );
    }
}
