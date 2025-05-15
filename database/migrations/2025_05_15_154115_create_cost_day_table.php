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
        Schema::create('cost_day', function (Blueprint $table) {
            $table->unsignedBigInteger('cost_id');
            $table->foreign('cost_id')->references('id')->on('costs')->cascadeOnDelete();
            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id')->references('id')->on('days')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->primary(['cost_id', 'day_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_day');
    }
};
