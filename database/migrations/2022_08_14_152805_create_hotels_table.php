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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id')->index()->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete(null);
            $table->string('name');
            $table->string('name_cn')->nullable();
            $table->string('map')->nullable();
            $table->string('main_image')->nullable();
            $table->integer('stars')->default(5);
            $table->text('body');
            $table->text('body_cn')->nullable();
            $table->unsignedInteger('viewed')->default(0)->nullable();
            $table->boolean('recommended')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
};
