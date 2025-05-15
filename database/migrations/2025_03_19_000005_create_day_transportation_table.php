<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('day_transportation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_id')->constrained()->onDelete('cascade');
            $table->foreignId('transportation_id')->constrained('transportations')->onDelete('cascade');
            $table->time('pickup_time')->nullable();
            $table->time('dropoff_time')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('dropoff_location')->nullable();
            $table->integer('estimated_duration')->nullable(); // in minutes
            $table->text('route_notes')->nullable();
            $table->timestamps();

            $table->unique(['day_id', 'transportation_id', 'pickup_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('day_transportation');
    }
}; 