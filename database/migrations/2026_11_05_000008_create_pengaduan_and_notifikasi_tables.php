<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan_pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('id_dusun')->nullable()->constrained('wilayah_dusun', 'id_dusun')->nullOnDelete();
            $table->string('judul_laporan', 200);
            $table->enum('kategori', [
                'Infrastruktur & Jalan',
                'Pertanian & Pengairan',
                'Bantuan Sosial',
                'Pelayanan Kelurahan',
                'Keamanan & Ketertiban',
                'Lainnya',
            ])->default('Infrastruktur & Jalan');
            $table->text('isi_laporan');
            $table->string('foto_bukti', 255)->nullable();
            $table->enum('status', [
                'diajukan',
                'ditinjau',
                'dalam_tindakan',
                'selesai',
                'ditolak',
            ])->default('diajukan');
            $table->text('tanggapan_petugas')->nullable();
            $table->dateTime('tanggal_tanggapan')->nullable();
            $table->timestamps();
        });

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->string('judul', 150);
            $table->text('pesan');
            $table->enum('kanal', ['web', 'whatsapp', 'email'])->default('web');
            $table->string('tautan', 255)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('layanan_pengaduan');
    }
};
