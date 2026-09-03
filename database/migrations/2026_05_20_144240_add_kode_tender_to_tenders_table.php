<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tenders', 'kode_tender')) {
            Schema::table('tenders', function (Blueprint $table) {
                $table->string('kode_tender')->unique()->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tenders', 'kode_tender')) {
            Schema::table('tenders', function (Blueprint $table) {
                $table->dropColumn('kode_tender');
            });
        }
    }
};
