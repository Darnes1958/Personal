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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('invoice_date');
            $table->foreignIdFor(\App\Models\Bank::class);
            $table->bigInteger('invoice_number')->unique();
            $table->string('specifications');
            $table->string('engine_number')->unique();
            $table->string('color');
            $table->string('model');
            $table->string('chassis_number');
            $table->bigInteger('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
