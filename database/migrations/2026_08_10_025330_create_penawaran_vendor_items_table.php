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
        Schema::create('penawaran_vendor_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_quotation_id')->constrained('penawaran_vendor')->onDelete('cascade');
            $table->foreignId('material_request_item_id')->constrained('material_request_items')->onDelete('cascade');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran_vendor_items');
    }
};
