<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->foreignId('material_request_id')
                ->after('kode_tender')
                ->constrained('material_requests')
                ->cascadeOnDelete();

            $table->string('nama_tender')->after('material_request_id');
            $table->date('deadline')->after('nama_tender');
            $table->text('catatan')->nullable()->after('deadline');

            $table->enum('status', [
                'draft',
                'dikirim',
                'penawaran_masuk',
                'negosiasi',
                'vendor_terpilih',
                'selesai',
                'dibatalkan'
            ])->default('draft')->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropForeign(['material_request_id']);
            $table->dropColumn([
                'material_request_id',
                'nama_tender',
                'deadline',
                'catatan',
                'status',
            ]);
        });
    }
};
