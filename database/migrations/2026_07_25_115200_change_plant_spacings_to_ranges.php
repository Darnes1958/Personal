<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('plant_spacings', 'row_spacing_cm')) {
            return;
        }

        Schema::table('plant_spacings', function (Blueprint $table) {
            $table->dropColumn(['row_spacing_cm', 'plant_spacing_cm', 'depth_cm']);
        });

        Schema::table('plant_spacings', function (Blueprint $table) {
            $table->unsignedSmallInteger('row_spacing_from_cm')->after('planting_guide_id');
            $table->unsignedSmallInteger('row_spacing_to_cm')->after('row_spacing_from_cm');
            $table->unsignedSmallInteger('plant_spacing_from_cm')->after('row_spacing_to_cm');
            $table->unsignedSmallInteger('plant_spacing_to_cm')->after('plant_spacing_from_cm');
            $table->unsignedSmallInteger('depth_from_cm')->nullable()->after('plant_spacing_to_cm');
            $table->unsignedSmallInteger('depth_to_cm')->nullable()->after('depth_from_cm');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('plant_spacings', 'row_spacing_from_cm')) {
            return;
        }

        Schema::table('plant_spacings', function (Blueprint $table) {
            $table->dropColumn([
                'row_spacing_from_cm',
                'row_spacing_to_cm',
                'plant_spacing_from_cm',
                'plant_spacing_to_cm',
                'depth_from_cm',
                'depth_to_cm',
            ]);
        });

        Schema::table('plant_spacings', function (Blueprint $table) {
            $table->unsignedSmallInteger('row_spacing_cm')->after('planting_guide_id');
            $table->unsignedSmallInteger('plant_spacing_cm')->after('row_spacing_cm');
            $table->unsignedSmallInteger('depth_cm')->nullable()->after('plant_spacing_cm');
        });
    }
};
