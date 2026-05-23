<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->foreignId('purchase_order_id')
                ->after('id')
                ->constrained('purchase_orders')
                ->cascadeOnDelete();

            $table->string('nama_barang')->after('purchase_order_id');
            $table->text('spesifikasi')->nullable()->after('nama_barang');
            $table->integer('qty')->after('spesifikasi');
            $table->string('satuan')->after('qty');

            $table->decimal('harga_satuan', 15, 2)->default(0)->after('satuan');
            $table->decimal('subtotal', 15, 2)->default(0)->after('harga_satuan');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_id']);

            $table->dropColumn([
                'purchase_order_id',
                'nama_barang',
                'spesifikasi',
                'qty',
                'satuan',
                'harga_satuan',
                'subtotal',
            ]);
        });
    }
};
