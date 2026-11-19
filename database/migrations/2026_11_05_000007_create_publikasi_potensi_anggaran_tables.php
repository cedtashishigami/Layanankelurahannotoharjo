<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('potensi_kelurahan', function (Blueprint $table) {
            $table->id('id_potensi');
            $table->foreignId('id_dusun')->nullable()->constrained('wilayah_dusun', 'id_dusun')->nullOnDelete();
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('nama_potensi', 150);
            $table->enum('kategori', [
                'Pertanian',
                'Pasar Tradisional / Perdagangan',
                'UMKM & Industri Rumahan',
                'Peternakan',
                'Kuliner & Jasa',
            ])->default('Pertanian');
            $table->string('pemilik', 150)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('kontak', 30)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('lokasi', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('transparansi_anggaran', function (Blueprint $table) {
            $table->id('id_anggaran');
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->year('tahun_anggaran');
            $table->enum('jenis', ['Pendapatan', 'Belanja', 'Pembiayaan']);
            $table->string('bidang', 150);
            $table->string('uraian', 255);
            $table->decimal('target_anggaran', 15, 2)->default(0);
            $table->decimal('realisasi_anggaran', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->text('ringkasan')->nullable();
            $table->longText('isi_berita');
            $table->string('gambar', 255)->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });

        Schema::create('agenda', function (Blueprint $table) {
            $table->id('id_agenda');
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('nama_kegiatan', 200);
            $table->text('deskripsi')->nullable();
            $table->string('lokasi', 200);
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->string('penyelenggara', 150)->nullable();
            $table->timestamps();
        });

        Schema::create('galeri', function (Blueprint $table) {
            $table->id('id_galeri');
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('judul', 200);
            $table->string('file_media', 255);
            $table->enum('jenis_media', ['foto', 'video'])->default('foto');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
        Schema::dropIfExists('agenda');
        Schema::dropIfExists('berita');
        Schema::dropIfExists('transparansi_anggaran');
        Schema::dropIfExists('potensi_kelurahan');
    }
};
