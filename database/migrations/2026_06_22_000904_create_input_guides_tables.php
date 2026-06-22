<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('input_guides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('nature');
            $table->string('source');
            $table->json('components')->nullable();
            $table->string('timing_type');
            $table->string('timing_description');
            $table->json('target_categories')->nullable();
            $table->text('dosage_instructions')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('plant_input_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained('plants')->cascadeOnDelete();
            $table->foreignId('input_guide_id')->nullable()->constrained('input_guides')->nullOnDelete();
            $table->date('applied_at');
            $table->string('phenomenon')->nullable();
            $table->json('before_images')->nullable();
            $table->json('after_images')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_input_applications');
        Schema::dropIfExists('input_guides');
    }
};
