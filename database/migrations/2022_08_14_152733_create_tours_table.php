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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('map')->nullable();
            $table->string('main_image')->nullable();
            $table->text('body');
            $table->integer('total_days');
            // $table->integer('total_nights');
            $table->string('prices')->default(0);
            $table->unsignedInteger('discount_percent')->default(0);
            $table->dateTime('discount_datetime_start')->useCurrent()->nullable();
            $table->dateTime('discount_datetime_end')->useCurrent()->nullable();
            $table->unsignedInteger('viewed')->default(0)->nullable();
            $table->boolean('recommended')->default(0)->nullable();
            $table->unsignedInteger('liked')->default(0)->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
};
