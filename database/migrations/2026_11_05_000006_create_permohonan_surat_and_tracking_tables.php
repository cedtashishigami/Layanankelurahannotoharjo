<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_surat', function (Blueprint $table) {
            $table->id('id_permohonan_surat');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('id_penduduk')->constrained('penduduk', 'id_penduduk')->cascadeOnDelete();
            $table->foreignId('id_kode_surat')->constrained('kode_surat', 'id_kode_surat')->cascadeOnDelete();
            $table->string('nomor_surat', 100)->nullable();
            $table->date('tanggal_pengajuan');
            $table->text('keperluan');
            $table->text('keterangan_tambahan')->nullable();
            $table->enum('status', [
                'menunggu_verifikasi',
                'diverifikasi_kasi',
                'diparaf_sekretaris',
                'disetujui_lurah',
                'selesai',
                'ditolak',
            ])->default('menunggu_verifikasi');
            $table->string('token_qr', 100)->nullable()->unique();
            $table->string('file_pdf', 255)->nullable();
            $table->date('tanggal_disahkan')->nullable();
            $table->timestamps();
        });

        Schema::create('lampiran_permohonan', function (Blueprint $table) {
            $table->id('id_lampiran');
            $table->foreignId('id_permohonan_surat')->constrained('permohonan_surat', 'id_permohonan_surat')->cascadeOnDelete();
            $table->foreignId('id_syarat_surat')->constrained('syarat_surat', 'id_syarat_surat')->cascadeOnDelete();
            $table->string('nama_file', 255);
            $table->string('file_path', 255);
            $table->enum('status_validasi', ['menunggu', 'valid', 'tidak_valid'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('riwayat_status_surat', function (Blueprint $table) {
            $table->id('id_riwayat_surat');
            $table->foreignId('id_permohonan_surat')->constrained('permohonan_surat', 'id_permohonan_surat')->cascadeOnDelete();
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('tahapan', 100);
            $table->string('status_tahap', 50);
            $table->text('catatan_petugas')->nullable();
            $table->timestamps();
        });

        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id('id_surat_masuk');
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('nomor_surat', 100);
            $table->string('nomor_agenda_masuk', 100)->nullable();
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->string('pengirim', 150);
            $table->string('perihal', 255);
            $table->string('file_arsip', 255)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
        Schema::dropIfExists('riwayat_status_surat');
        Schema::dropIfExists('lampiran_permohonan');
        Schema::dropIfExists('permohonan_surat');
    }
};
