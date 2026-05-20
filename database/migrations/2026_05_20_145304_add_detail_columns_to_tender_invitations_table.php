<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tender_invitations', function (Blueprint $table) {
            $table->foreignId('tender_id')
                ->after('id')
                ->constrained('tenders')
                ->cascadeOnDelete();

            $table->foreignId('vendor_id')
                ->after('tender_id')
                ->constrained('vendors')
                ->cascadeOnDelete();

            $table->enum('status', [
                'dikirim',
                'dibaca',
                'ditawar',
                'tidak_merespons',
                'terpilih',
                'tidak_terpilih'
            ])->default('dikirim')->after('vendor_id');

            $table->timestamp('sent_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('tender_invitations', function (Blueprint $table) {
            $table->dropForeign(['tender_id']);
            $table->dropForeign(['vendor_id']);

            $table->dropColumn([
                'tender_id',
                'vendor_id',
                'status',
                'sent_at',
            ]);
        });
    }
};
