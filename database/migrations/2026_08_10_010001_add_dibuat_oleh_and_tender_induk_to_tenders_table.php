<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom:
     * - dibuat_oleh: user supply chain yang membuat Tender
     * - tender_induk_id: referensi ke tender sebelumnya (untuk tender ulang)
     */
    public function up(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            // Pembuat Tender (Supply Chain)
            $table->unsignedBigInteger('dibuat_oleh')->nullable()->after('status');
            $table->foreign('dibuat_oleh')->references('id')->on('users')->nullOnDelete();

            // Relasi tender ulang: merujuk ke tender induk yang digantikan
            $table->unsignedBigInteger('tender_induk_id')->nullable()->after('dibuat_oleh');
            $table->foreign('tender_induk_id')->references('id')->on('tenders')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropForeign(['dibuat_oleh']);
            $table->dropForeign(['tender_induk_id']);
            $table->dropColumn(['dibuat_oleh', 'tender_induk_id']);
        });
    }
};
