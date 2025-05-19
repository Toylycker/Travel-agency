<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('cost', 10, 2);
            $table->integer('number_of_people')->default(1);//number of people that item can be applies to for example car that can contain 3 people, meal that can feed 3 people
            $table->morphs('costable');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('cost_day', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_id')->constrained()->onDelete('cascade');
            $table->foreignId('day_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['cost_id', 'day_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_day');
        Schema::dropIfExists('costs');
    }
}; 