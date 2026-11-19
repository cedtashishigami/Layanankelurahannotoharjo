<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->foreignId('id_penduduk')->nullable()->constrained('penduduk', 'id_penduduk')->nullOnDelete();
            $table->foreignId('id_dusun')->nullable()->constrained('wilayah_dusun', 'id_dusun')->nullOnDelete();
            $table->string('name', 150);
            $table->string('email', 100)->unique();
            $table->string('nik', 20)->nullable()->unique();
            $table->string('no_hp', 25)->nullable();
            $table->string('password');
            $table->enum('role', [
                'admin',
                'lurah',
                'sekretaris',
                'kasi_pelayanan',
                'kasi_pemerintahan',
                'kasi_kesra',
                'kaur_keuangan',
                'kaur_umum',
                'kadus',
                'warga',
            ])->default('warga');
            $table->string('jabatan', 100)->nullable();
            $table->string('foto', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
