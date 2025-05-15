<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transportations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); // car, bus, van, etc.
            $table->string('brand')->nullable(); // Toyota, Mercedes, etc.
            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->unsignedInteger('seats')->nullable();
            $table->string('license_plate')->unique()->nullable();
            $table->string('color')->nullable();
            $table->boolean('has_wifi')->default(false);
            $table->boolean('has_ac')->default(true);
            $table->boolean('has_tv')->default(false);
            $table->text('features')->nullable(); // Additional features
            $table->date('insurance_expiry')->nullable();
            $table->date('technical_inspection_expiry')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transportations');
    }
}; 