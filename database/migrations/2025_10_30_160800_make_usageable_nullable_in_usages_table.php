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
        // Use raw statements to avoid requiring doctrine/dbal for column change()
        DB::statement('ALTER TABLE `usages` MODIFY `usageable_type` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `usages` MODIFY `usageable_id` BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `usages` MODIFY `usageable_type` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `usages` MODIFY `usageable_id` BIGINT UNSIGNED NOT NULL');
    }
};