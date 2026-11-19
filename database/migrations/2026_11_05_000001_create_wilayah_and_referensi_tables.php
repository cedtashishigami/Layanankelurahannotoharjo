<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayah_dusun', function (Blueprint $table) {
            $table->id('id_dusun');
            $table->string('nama_dusun', 100);
            $table->string('nama_kadus', 150)->nullable();
            $table->string('kontak_kadus', 20)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('wilayah_rt', function (Blueprint $table) {
            $table->id('id_rt');
            $table->foreignId('id_dusun')->constrained('wilayah_dusun', 'id_dusun')->cascadeOnDelete();
            $table->string('nomor_rt', 10);
            $table->string('nomor_rw', 10);
            $table->string('nama_ketua_rt', 150)->nullable();
            $table->string('kontak_rt', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('pendidikan', function (Blueprint $table) {
            $table->id('id_pendidikan');
            $table->string('nama_pendidikan', 100);
            $table->boolean('is_delete')->default(false);
            $table->timestamps();
        });

        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->id('id_pekerjaan');
            $table->string('nama_pekerjaan', 100);
            $table->string('warna', 30)->nullable();
            $table->boolean('is_delete')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pekerjaan');
        Schema::dropIfExists('pendidikan');
        Schema::dropIfExists('wilayah_rt');
        Schema::dropIfExists('wilayah_dusun');
    }
};
