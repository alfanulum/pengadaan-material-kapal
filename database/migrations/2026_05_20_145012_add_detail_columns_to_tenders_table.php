<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            if (!Schema::hasColumn('tenders', 'material_request_id')) {
                $table->foreignId('material_request_id')
                    ->after('kode_tender')
                    ->constrained('material_requests')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('tenders', 'nama_tender')) {
                $table->string('nama_tender')->after('material_request_id');
            }

            if (!Schema::hasColumn('tenders', 'deadline')) {
                $table->date('deadline')->after('nama_tender');
            }

            if (!Schema::hasColumn('tenders', 'catatan')) {
                $table->text('catatan')->nullable()->after('deadline');
            }

            if (!Schema::hasColumn('tenders', 'status')) {
                $table->enum('status', [
                    'draft',
                    'dikirim',
                    'penawaran_masuk',
                    'negosiasi',
                    'vendor_terpilih',
                    'selesai',
                    'dibatalkan'
                ])->default('draft')->after('catatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            if (Schema::hasColumn('tenders', 'material_request_id')) {
                $table->dropForeign(['material_request_id']);
                $table->dropColumn('material_request_id');
            }
            $columnsToDrop = array_filter(['nama_tender', 'deadline', 'catatan', 'status'], function ($col) {
                return Schema::hasColumn('tenders', $col);
            });
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
