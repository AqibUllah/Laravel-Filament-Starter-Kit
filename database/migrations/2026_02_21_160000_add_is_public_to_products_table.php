<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->after('is_featured');
            $table->index(['is_public', 'is_active']);
            $table->index(['is_public', 'is_featured']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_public', 'is_active']);
            $table->dropIndex(['is_public', 'is_featured']);
            $table->dropColumn('is_public');
        });
    }
};
