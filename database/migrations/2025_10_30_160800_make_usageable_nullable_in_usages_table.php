<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

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