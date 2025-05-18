<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('type')->nullable(); // breakfast, lunch, dinner, snack
            $table->string('cuisine')->nullable(); // Turkish, Italian, etc.
            $table->boolean('is_vegetarian')->default(false);
            $table->boolean('is_vegan')->default(false);
            $table->boolean('is_halal')->default(true);
            $table->boolean('contains_nuts')->default(false);
            $table->boolean('contains_dairy')->default(false);
            $table->boolean('contains_gluten')->default(false);
            $table->json('allergens')->nullable(); // Array of allergens
            $table->decimal('calories', 8, 2)->nullable();
            $table->integer('preparation_time')->nullable(); // in minutes
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
}; 