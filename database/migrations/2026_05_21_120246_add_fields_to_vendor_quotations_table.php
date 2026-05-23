<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_quotations', function (Blueprint $table) {
            $table->foreignId('tender_id')
                ->after('id')
                ->constrained('tenders')
                ->cascadeOnDelete();

            $table->foreignId('vendor_id')
                ->after('tender_id')
                ->constrained('vendors')
                ->cascadeOnDelete();

            $table->decimal('harga_penawaran', 15, 2)->after('vendor_id');
            $table->integer('estimasi_pengiriman')->nullable()->after('harga_penawaran');
            $table->text('catatan')->nullable()->after('estimasi_pengiriman');
            $table->string('file_penawaran')->nullable()->after('catatan');

            $table->enum('status', [
                'dikirim',
                'direview',
                'diterima',
                'ditolak'
            ])->default('dikirim')->after('file_penawaran');
        });
    }

    public function down(): void
    {
        Schema::table('vendor_quotations', function (Blueprint $table) {
            $table->dropForeign(['tender_id']);
            $table->dropForeign(['vendor_id']);

            $table->dropColumn([
                'tender_id',
                'vendor_id',
                'harga_penawaran',
                'estimasi_pengiriman',
                'catatan',
                'file_penawaran',
                'status',
            ]);
        });
    }
};
