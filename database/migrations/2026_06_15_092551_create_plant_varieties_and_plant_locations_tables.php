<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plant_varieties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('plant_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('plants', function (Blueprint $table) {
            $table->foreignId('plant_variety_id')
                ->nullable()
                ->after('name')
                ->constrained('plant_varieties')
                ->nullOnDelete();
            $table->foreignId('plant_location_id')
                ->nullable()
                ->after('planted_at')
                ->constrained('plant_locations')
                ->nullOnDelete();
        });

        $this->migrateExistingValues('variety', 'plant_varieties', 'plant_variety_id');
        $this->migrateExistingValues('location', 'plant_locations', 'plant_location_id');

        Schema::table('plants', function (Blueprint $table) {
            $table->dropColumn(['variety', 'location']);
        });
    }

    public function down(): void
    {
        Schema::table('plants', function (Blueprint $table) {
            $table->string('variety')->nullable()->after('name');
            $table->string('location')->nullable()->after('planted_at');
        });

        $plants = DB::table('plants')->get(['id', 'plant_variety_id', 'plant_location_id']);

        foreach ($plants as $plant) {
            $variety = $plant->plant_variety_id
                ? DB::table('plant_varieties')->where('id', $plant->plant_variety_id)->value('name')
                : null;
            $location = $plant->plant_location_id
                ? DB::table('plant_locations')->where('id', $plant->plant_location_id)->value('name')
                : null;

            DB::table('plants')->where('id', $plant->id)->update([
                'variety' => $variety,
                'location' => $location,
            ]);
        }

        Schema::table('plants', function (Blueprint $table) {
            $table->dropConstrainedForeignId('plant_variety_id');
            $table->dropConstrainedForeignId('plant_location_id');
        });

        Schema::dropIfExists('plant_locations');
        Schema::dropIfExists('plant_varieties');
    }

    private function migrateExistingValues(string $sourceColumn, string $lookupTable, string $foreignColumn): void
    {
        $values = DB::table('plants')
            ->whereNotNull($sourceColumn)
            ->where($sourceColumn, '!=', '')
            ->distinct()
            ->pluck($sourceColumn);

        foreach ($values as $value) {
            $id = DB::table($lookupTable)->insertGetId([
                'name' => $value,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('plants')
                ->where($sourceColumn, $value)
                ->update([$foreignColumn => $id]);
        }
    }
};
