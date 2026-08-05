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
        Schema::disableForeignKeyConstraints();

        Schema::rename('vendor_quotations', 'penawaran_vendor');
        Schema::rename('tender_invitations', 'undangan_tender');
        Schema::rename('tender_clarifications', 'tender_klarifikasi');
        Schema::rename('tender_messages', 'tender_negosiasi');
        Schema::rename('shipments', 'pengiriman_barang');
        Schema::rename('goods_receipts', 'penerimaan_barang');
        Schema::rename('goods_receipt_photos', 'foto_penerimaan_barang');

        Schema::dropIfExists('procurement_chats');
        Schema::dropIfExists('procurement_audits');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::rename('penawaran_vendor', 'vendor_quotations');
        Schema::rename('undangan_tender', 'tender_invitations');
        Schema::rename('tender_klarifikasi', 'tender_clarifications');
        Schema::rename('tender_negosiasi', 'tender_messages');
        Schema::rename('pengiriman_barang', 'shipments');
        Schema::rename('penerimaan_barang', 'goods_receipts');
        Schema::rename('foto_penerimaan_barang', 'goods_receipt_photos');

        Schema::create('procurement_chats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('procurement_audits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }
};
