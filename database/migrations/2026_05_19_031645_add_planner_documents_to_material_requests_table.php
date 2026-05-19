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
        Schema::table('material_requests', function (Blueprint $table) {
            $table->decimal('total_rab', 15, 2)->nullable()->after('tanggal_dibutuhkan');
            $table->string('file_rab')->nullable()->after('total_rab');
            $table->string('file_perizinan')->nullable()->after('file_rab');
            $table->text('catatan_planner')->nullable()->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_requests', function (Blueprint $table) {
            $table->dropColumn([
                'total_rab',
                'file_rab',
                'file_perizinan',
                'catatan_planner',
            ]);
        });
    }
};
