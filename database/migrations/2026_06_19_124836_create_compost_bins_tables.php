<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compost_bins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('material_type')->nullable();
            $table->string('stage')->default('empty');
            $table->date('stage_started_at')->nullable();
            $table->foreignId('plant_location_id')->nullable()->constrained('plant_locations')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('compost_bin_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compost_bin_id')->constrained('compost_bins')->cascadeOnDelete();
            $table->string('type');
            $table->date('event_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compost_bin_events');
        Schema::dropIfExists('compost_bins');
    }
};
