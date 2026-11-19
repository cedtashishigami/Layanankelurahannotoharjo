<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasi_penduduk', function (Blueprint $table) {
            $table->id('id_mutasi');
            $table->foreignId('id_penduduk')->constrained('penduduk', 'id_penduduk')->cascadeOnDelete();
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->enum('jenis_mutasi', ['Kelahiran', 'Kematian', 'Pindah_Masuk', 'Pindah_Keluar']);
            $table->date('tanggal_kejadian');
            $table->string('nomor_surat_keterangan', 100)->nullable();
            $table->text('alasan_tujuan')->nullable();
            $table->string('file_berkas_bukti', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_penduduk');
    }
};
