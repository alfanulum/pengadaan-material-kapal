<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tender_invitations', function (Blueprint $table) {
            if (!Schema::hasColumn('tender_invitations', 'tender_id')) {
                $table->foreignId('tender_id')
                    ->after('id')
                    ->constrained('tenders')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('tender_invitations', 'vendor_id')) {
                $table->foreignId('vendor_id')
                    ->after('tender_id')
                    ->constrained('vendors')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('tender_invitations', 'status')) {
                $table->enum('status', [
                    'dikirim',
                    'dibaca',
                    'ditawar',
                    'tidak_merespons',
                    'terpilih',
                    'tidak_terpilih'
                ])->default('dikirim')->after('vendor_id');
            }

            if (!Schema::hasColumn('tender_invitations', 'sent_at')) {
                $table->timestamp('sent_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tender_invitations', function (Blueprint $table) {
            if (Schema::hasColumn('tender_invitations', 'tender_id')) {
                $table->dropForeign(['tender_id']);
                $table->dropColumn('tender_id');
            }
            if (Schema::hasColumn('tender_invitations', 'vendor_id')) {
                $table->dropForeign(['vendor_id']);
                $table->dropColumn('vendor_id');
            }
            $columnsToDrop = array_filter(['status', 'sent_at'], function ($col) {
                return Schema::hasColumn('tender_invitations', $col);
            });
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
