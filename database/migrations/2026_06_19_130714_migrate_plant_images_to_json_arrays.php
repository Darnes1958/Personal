<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $plants = DB::table('plants')->get(['id', 'card_image']);

        Schema::table('plants', function (Blueprint $table) {
            $table->dropColumn('card_image');
        });

        Schema::table('plants', function (Blueprint $table) {
            $table->json('card_image')->nullable();
        });

        foreach ($plants as $plant) {
            if (filled($plant->card_image)) {
                DB::table('plants')->where('id', $plant->id)->update([
                    'card_image' => json_encode([$plant->card_image]),
                ]);
            }
        }

        Schema::table('plant_events', function (Blueprint $table) {
            $table->json('images')->nullable();
        });

        $eventImages = DB::table('plant_event_images')
            ->orderBy('plant_event_id')
            ->orderBy('sort_order')
            ->get(['plant_event_id', 'path']);

        $imagesByEvent = $eventImages->groupBy('plant_event_id');

        foreach ($imagesByEvent as $eventId => $images) {
            DB::table('plant_events')->where('id', $eventId)->update([
                'images' => json_encode($images->pluck('path')->values()->all()),
            ]);
        }

        Schema::dropIfExists('plant_event_images');
    }

    public function down(): void
    {
        Schema::create('plant_event_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_event_id')->constrained('plant_events')->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $events = DB::table('plant_events')->whereNotNull('images')->get(['id', 'images']);

        foreach ($events as $event) {
            $paths = json_decode($event->images, true) ?? [];

            foreach ($paths as $index => $path) {
                DB::table('plant_event_images')->insert([
                    'plant_event_id' => $event->id,
                    'path' => $path,
                    'sort_order' => $index,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Schema::table('plant_events', function (Blueprint $table) {
            $table->dropColumn('images');
        });

        $plants = DB::table('plants')->whereNotNull('card_image')->get(['id', 'card_image']);

        Schema::table('plants', function (Blueprint $table) {
            $table->dropColumn('card_image');
        });

        Schema::table('plants', function (Blueprint $table) {
            $table->string('card_image')->nullable();
        });

        foreach ($plants as $plant) {
            $paths = json_decode($plant->card_image, true) ?? [];

            DB::table('plants')->where('id', $plant->id)->update([
                'card_image' => $paths[0] ?? null,
            ]);
        }
    }
};
