<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom:
     * - dibuat_oleh: user supply chain yang membuat PO
     * - tanggal_pengunduran_diri: kapan vendor mengundurkan diri
     * - alasan_pengunduran_diri: alasan vendor mundur
     * Dan menambahkan status 'vendor_mundur' ke enum.
     */
    public function up(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            // Pembuat PO (Supply Chain)
            $table->unsignedBigInteger('dibuat_oleh')->nullable()->after('is_archived');
            $table->foreign('dibuat_oleh')->references('id')->on('users')->nullOnDelete();

            // Pengunduran diri Vendor
            $table->timestamp('tanggal_pengunduran_diri')->nullable()->after('dibuat_oleh');
            $table->text('alasan_pengunduran_diri')->nullable()->after('tanggal_pengunduran_diri');
        });

        // Tambahkan status 'vendor_mundur' ke enum purchase_orders.status
        DB::statement("ALTER TABLE purchase_orders MODIFY COLUMN status ENUM(
            'draft',
            'dikirim_ke_vendor',
            'diproses_vendor',
            'dikirim',
            'selesai',
            'dibatalkan',
            'retur',
            'penggantian_vendor',
            'menunggu_tindak_lanjut',
            'vendor_mundur'
        ) DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan enum tanpa 'vendor_mundur'
        DB::statement("ALTER TABLE purchase_orders MODIFY COLUMN status ENUM(
            'draft',
            'dikirim_ke_vendor',
            'diproses_vendor',
            'dikirim',
            'selesai',
            'dibatalkan',
            'retur',
            'penggantian_vendor',
            'menunggu_tindak_lanjut'
        ) DEFAULT 'draft'");

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropForeign(['dibuat_oleh']);
            $table->dropColumn([
                'dibuat_oleh',
                'tanggal_pengunduran_diri',
                'alasan_pengunduran_diri',
            ]);
        });
    }
};
