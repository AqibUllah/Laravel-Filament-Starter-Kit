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
        Schema::create('usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('plan_feature_id')->nullable()->constrained()->onDelete('set null');

            // Polymorphic relationship for tracking usage of different entities
            $table->morphs('usageable');

            // Usage tracking fields
            $table->string('metric_name'); // e.g., 'api_calls', 'storage_gb', 'users'
            $table->decimal('quantity', 10, 4); // The amount of usage
            $table->decimal('unit_price', 8, 4)->default(0); // Price per unit
            $table->decimal('total_amount', 10, 2)->default(0); // Total cost for this usage

            // Billing period tracking
            $table->datetime('billing_period_start');
            $table->datetime('billing_period_end');
            $table->datetime('recorded_at');

            // Additional metadata
            $table->json('metadata')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['team_id', 'billing_period_start', 'billing_period_end']);
            $table->index(['metric_name', 'billing_period_start']);
            $table->index(['subscription_id', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usages');
    }
};
