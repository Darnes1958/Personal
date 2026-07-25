<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plant_spacings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planting_guide_id')->constrained('planting_guides')->cascadeOnDelete();
            $table->unsignedSmallInteger('row_spacing_cm');
            $table->unsignedSmallInteger('plant_spacing_cm');
            $table->unsignedSmallInteger('depth_cm')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_spacings');
    }
};
