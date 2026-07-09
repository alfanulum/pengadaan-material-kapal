<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->date('tanggal_diterima');
            $table->integer('jumlah_diterima');
            $table->enum('kondisi_barang', [
                'sesuai',
                'diterima_dengan_catatan',
                'kerusakan',
                'tidak_sesuai_spesifikasi',
            ]);
            $table->text('catatan_gudang')->nullable();
            $table->text('detail_permasalahan')->nullable();
            $table->integer('jumlah_rusak')->nullable();
            $table->enum('tindakan_selanjutnya', [
                'terima_dengan_catatan',
                'minta_penggantian',
                'retur_sebagian',
                'tolak_barang',
            ])->nullable();
            $table->enum('status_penerimaan', [
                'diterima_sesuai',
                'diterima_dengan_catatan',
                'menunggu_tindak_lanjut',
                'retur_barang',
                'penggantian_vendor',
            ])->default('diterima_sesuai');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
