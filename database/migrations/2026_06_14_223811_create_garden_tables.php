<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planting_guides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->string('batch_label')->nullable();
            $table->string('planting_start', 5);
            $table->string('planting_end', 5);
            $table->string('harvest_start', 5)->nullable();
            $table->string('harvest_end', 5)->nullable();
            $table->string('season')->nullable();
            $table->string('region')->default('الساحل الليبي');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('variety')->nullable();
            $table->string('category');
            $table->date('planted_at')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('active');
            $table->string('card_image')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('planting_guide_id')->nullable()->constrained('planting_guides')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('plant_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained('plants')->cascadeOnDelete();
            $table->string('type');
            $table->date('event_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('plant_event_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_event_id')->constrained('plant_events')->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('garden_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('plant_id')->nullable()->constrained('plants')->nullOnDelete();
            $table->string('type');
            $table->date('due_date');
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garden_tasks');
        Schema::dropIfExists('plant_event_images');
        Schema::dropIfExists('plant_events');
        Schema::dropIfExists('plants');
        Schema::dropIfExists('planting_guides');
    }
};
