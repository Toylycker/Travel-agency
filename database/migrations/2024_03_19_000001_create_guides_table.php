<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('resume_path')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedInteger('years_of_experience')->default(0);
            $table->json('languages')->nullable(); // Array of languages the guide speaks
            $table->string('license_number')->nullable();
            $table->date('license_expiry')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
}; 