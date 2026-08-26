<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'retur', 'penggantian_vendor', 'menunggu_tindak_lanjut' to enum
        DB::statement("ALTER TABLE purchase_orders MODIFY COLUMN status ENUM('draft', 'dikirim_ke_vendor', 'diproses_vendor', 'dikirim', 'selesai', 'dibatalkan', 'retur', 'penggantian_vendor', 'menunggu_tindak_lanjut') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE purchase_orders MODIFY COLUMN status ENUM('draft', 'dikirim_ke_vendor', 'diproses_vendor', 'dikirim', 'selesai', 'dibatalkan') DEFAULT 'draft'");
    }
};
