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
        Schema::table('shipments', function (Blueprint $table) {
            $table->foreignId('purchase_order_id')
                ->after('id')
                ->constrained('purchase_orders')
                ->cascadeOnDelete();

            $table->foreignId('tender_id')
                ->after('purchase_order_id')
                ->constrained('tenders')
                ->cascadeOnDelete();

            $table->foreignId('vendor_id')
                ->after('tender_id')
                ->constrained('vendors')
                ->cascadeOnDelete();

            $table->timestamp('tanggal_kirim')->nullable()->after('vendor_id');

            $table->enum('status', [
                'dikirim',
                'diterima_gudang',
            ])->default('dikirim')->after('tanggal_kirim');

            $table->text('catatan')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_id']);
            $table->dropForeign(['tender_id']);
            $table->dropForeign(['vendor_id']);
            $table->dropColumn([
                'purchase_order_id',
                'tender_id',
                'vendor_id',
                'tanggal_kirim',
                'status',
                'catatan',
            ]);
        });
    }
};
