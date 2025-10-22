<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('domain')->nullable();
            $table->boolean('status')->default(true);
            $table->text('logo')->nullable();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();

            // Plan Limits
            $table->unsignedInteger('max_users')->default(3);
            $table->unsignedInteger('max_projects')->default(5);
            $table->unsignedBigInteger('max_storage_db')->default(104857600); // 100MB in bytes

            // Feature Toggles (boolean flags)
            $table->boolean('feature_chat')->default(false);
            $table->boolean('feature_api_access')->default(false);
            $table->boolean('feature_custom_domain')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teams');
    }
};
