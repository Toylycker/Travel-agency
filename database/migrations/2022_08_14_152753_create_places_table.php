<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('location_id')->index()->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
            $table->string('name');
            $table->string('name_cn')->nullable();
            $table->text('map')->nullable();
            $table->text('body');
            $table->text('body_cn')->nullable();
            $table->unsignedInteger('viewed')->default(0)->nullable();
            $table->boolean('recommended')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
};
