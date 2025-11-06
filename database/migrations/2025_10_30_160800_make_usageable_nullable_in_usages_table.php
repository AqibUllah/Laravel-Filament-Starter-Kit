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
        // Use Laravel's Schema builder for cross-database compatibility
        Schema::table('usages', function (Blueprint $table) {
            $table->string('usageable_type')->nullable()->change();
            $table->unsignedBigInteger('usageable_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usages', function (Blueprint $table) {
            $table->string('usageable_type')->nullable(false)->change();
            $table->unsignedBigInteger('usageable_id')->nullable(false)->change();
        });
    }
};
