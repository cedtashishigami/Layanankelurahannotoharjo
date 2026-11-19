<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lampiran_permohonan', function (Blueprint $table): void {
            $table->longText('file_data')->nullable()->after('file_path');
            $table->string('mime_type', 100)->nullable()->after('file_data');
        });

        Schema::table('layanan_pengaduan', function (Blueprint $table): void {
            $table->longText('foto_data')->nullable()->after('foto_bukti');
            $table->string('foto_mime', 100)->nullable()->after('foto_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lampiran_permohonan', function (Blueprint $table): void {
            $table->dropColumn(['file_data', 'mime_type']);
        });

        Schema::table('layanan_pengaduan', function (Blueprint $table): void {
            $table->dropColumn(['foto_data', 'foto_mime']);
        });
    }
};
