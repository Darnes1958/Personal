<?php

use App\Models\Acc;
use App\Models\Customer;
use App\Models\User;
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
        Schema::create('trans', function (Blueprint $table) {
            $table->id();
            $table->date('tran_date');
            $table->smallInteger('tran_type');
            $table->decimal('tran_value',12,3);
            $table->string('notes')->nullable();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(Acc::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans');
    }
};
