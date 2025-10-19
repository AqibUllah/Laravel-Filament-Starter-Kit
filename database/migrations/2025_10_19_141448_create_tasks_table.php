<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreignId('assigned_by');
            $table->foreignId('assigned_to');
            $table->string('title');
            $table->string('description')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('priority',['low', 'medium', 'high'])->default('medium');
            $table->enum('status',['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->json('tags')->nullable();
            $table->integer('estimated_hours')->nullable();
            $table->integer('actual_hours')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['team_id', 'status']);
            $table->index(['team_id', 'assigned_to']);
            $table->index(['team_id', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
