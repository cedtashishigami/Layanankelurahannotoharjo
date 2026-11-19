<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->id('id_kartu_keluarga');
            $table->foreignId('id_rt')->constrained('wilayah_rt', 'id_rt')->cascadeOnDelete();
            $table->string('nomor_kk', 20)->unique();
            $table->string('nama_kepala_keluarga', 150)->nullable();
            $table->text('alamat_lengkap');
            $table->string('kode_pos', 10)->default('34172');
            $table->timestamps();
        });

        Schema::create('penduduk', function (Blueprint $table) {
            $table->id('id_penduduk');
            $table->foreignId('id_kartu_keluarga')->constrained('kartu_keluarga', 'id_kartu_keluarga')->cascadeOnDelete();
            $table->foreignId('id_pekerjaan')->nullable()->constrained('pekerjaan', 'id_pekerjaan')->nullOnDelete();
            $table->foreignId('id_pendidikan')->nullable()->constrained('pendidikan', 'id_pendidikan')->nullOnDelete();
            $table->string('nik', 20)->unique();
            $table->string('nama_lengkap', 150);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('agama', 30)->default('Islam');
            $table->string('status_kawin', 30)->default('Belum Menikah');
            $table->string('status_hubungan_keluarga', 50)->default('Kepala Keluarga');
            $table->string('kewarganegaraan', 30)->default('WNI');
            $table->string('nama_ayah', 150)->nullable();
            $table->string('nama_ibu', 150)->nullable();
            $table->string('no_telepon', 25)->nullable();
            $table->enum('status_keberadaan', ['Aktif', 'Meninggal', 'Pindah'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
        Schema::dropIfExists('kartu_keluarga');
    }
};
