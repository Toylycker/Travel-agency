<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('day_meal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_id')->constrained()->onDelete('cascade');
            $table->foreignId('meal_id')->constrained()->onDelete('cascade');
            $table->time('serving_time')->nullable();
            $table->string('serving_location')->nullable();
            $table->text('special_requests')->nullable();
            $table->timestamps();

            $table->unique(['day_id', 'meal_id', 'serving_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('day_meal');
    }
}; 