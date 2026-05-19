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
        Schema::create('material_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('kode_pengajuan')->unique();
            $table->date('tanggal_dibutuhkan');
            $table->text('catatan')->nullable();

            $table->enum('status', [
                'diajukan',
                'diproses_planner',
                'disetujui',
                'ditolak',
                'selesai'
            ])->default('diajukan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requests');
    }
};
