<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kode_surat', function (Blueprint $table) {
            $table->id('id_kode_surat');
            $table->string('kode_klasifikasi', 50);
            $table->string('nama_surat', 150);
            $table->string('template_view', 100)->nullable();
            $table->integer('masa_berlaku_hari')->default(30);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('syarat_surat', function (Blueprint $table) {
            $table->id('id_syarat_surat');
            $table->foreignId('id_kode_surat')->constrained('kode_surat', 'id_kode_surat')->cascadeOnDelete();
            $table->string('nama_syarat', 150);
            $table->boolean('is_wajib')->default(true);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('syarat_surat');
        Schema::dropIfExists('kode_surat');
    }
};
