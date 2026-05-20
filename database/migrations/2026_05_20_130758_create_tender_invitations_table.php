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
        Schema::create('tender_invitations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tender_id')
                ->constrained('tenders')
                ->cascadeOnDelete();

            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->cascadeOnDelete();

            $table->enum('status', [
                'dikirim',
                'dibaca',
                'ditawar',
                'tidak_merespons',
                'terpilih',
                'tidak_terpilih'
            ])->default('dikirim');

            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_invitations');
    }
};
