<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tender_clarifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tender_id')
                ->constrained('tenders')
                ->cascadeOnDelete();

            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->cascadeOnDelete();

            $table->foreignId('engineer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('sender_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('message');

            $table->enum('status', [
                'terkirim',
                'dibaca'
            ])->default('terkirim');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_clarifications');
    }
};
