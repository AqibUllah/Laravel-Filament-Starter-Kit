<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('filament-email-templates.table_name'), function (Blueprint $table) {
            if (! Schema::hasColumn(config('filament-email-templates.table_name'), 'team_id')) {
                $table->foreignId('team_id')->nullable()->after('id')->constrained('teams')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table(config('filament-email-templates.table_name'), function (Blueprint $table) {
            if (Schema::hasColumn(config('filament-email-templates.table_name'), 'team_id')) {
                $table->dropConstrainedForeignId('team_id');
            }
        });
    }
};
