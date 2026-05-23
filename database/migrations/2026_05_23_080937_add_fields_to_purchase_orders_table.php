<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('kode_po')->unique()->after('id');

            $table->foreignId('tender_id')
                ->after('kode_po')
                ->constrained('tenders')
                ->cascadeOnDelete();

            $table->foreignId('vendor_id')
                ->after('tender_id')
                ->constrained('vendors')
                ->cascadeOnDelete();

            $table->foreignId('vendor_quotation_id')
                ->after('vendor_id')
                ->constrained('vendor_quotations')
                ->cascadeOnDelete();

            $table->date('tanggal_po')->after('vendor_quotation_id');
            $table->date('deadline_pengiriman')->nullable()->after('tanggal_po');

            $table->decimal('total_harga', 15, 2)->default(0)->after('deadline_pengiriman');

            $table->text('catatan')->nullable()->after('total_harga');

            $table->enum('status', [
                'draft',
                'dikirim_ke_vendor',
                'diproses_vendor',
                'dikirim',
                'selesai',
                'dibatalkan'
            ])->default('draft')->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropForeign(['tender_id']);
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['vendor_quotation_id']);

            $table->dropColumn([
                'kode_po',
                'tender_id',
                'vendor_id',
                'vendor_quotation_id',
                'tanggal_po',
                'deadline_pengiriman',
                'total_harga',
                'catatan',
                'status',
            ]);
        });
    }
};
