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
        Schema::table('tender_clarifications', function (Blueprint $table) {
            $table->string('attachment')->nullable()->after('message');
        });

        Schema::table('tender_messages', function (Blueprint $table) {
            $table->string('attachment')->nullable()->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_tables', function (Blueprint $table) {
            //
        });
    }
};
