<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            // Status registrasi vendor: menunggu, disetujui, ditolak
            $table->enum('status_registrasi', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu')
                ->after('status');

            // Alasan penolakan dari Supply Chain
            $table->text('alasan_penolakan')->nullable()->after('status_registrasi');

            // Tanggal Vendor mendaftar
            $table->timestamp('tanggal_daftar')->nullable()->after('alasan_penolakan');

            // Tanggal verifikasi oleh Supply Chain
            $table->timestamp('tanggal_verifikasi')->nullable()->after('tanggal_daftar');

            // ID user Supply Chain yang melakukan verifikasi
            $table->foreignId('id_verifikator')
                ->nullable()
                ->after('tanggal_verifikasi')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropForeign(['id_verifikator']);
            $table->dropColumn([
                'status_registrasi',
                'alasan_penolakan',
                'tanggal_daftar',
                'tanggal_verifikasi',
                'id_verifikator',
            ]);
        });
    }
};
