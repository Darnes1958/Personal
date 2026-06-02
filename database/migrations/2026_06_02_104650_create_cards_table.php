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

        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->integer('ser');
            $table->string('name');
            $table->integer('card_no');
            $table->integer('nation_id');
            $table->string('id_no');
            $table->date('card_date');
            $table->integer('ical_no');
            $table->string('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
