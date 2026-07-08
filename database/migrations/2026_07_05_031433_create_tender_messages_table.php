<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tender_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tender_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();

            $table->enum('role', ['vendor', 'engineer', 'supply_chain']);
            $table->enum('type', ['clarification', 'negotiation']);

            $table->text('message');

            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_messages');
    }
};
