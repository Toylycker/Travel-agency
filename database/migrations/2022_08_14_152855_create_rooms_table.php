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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('room_quan')->default(5);
            $table->unsignedBigInteger('hotel_id')->index();
            $table->foreign('hotel_id')->references('id')->on('hotels')->cascadeOnDelete();
            $table->unsignedFloat('price')->default(0);
            $table->unsignedInteger('discount_percent')->default(0);
            $table->dateTime('discount_datetime_start')->useCurrent();
            $table->dateTime('discount_datetime_end')->useCurrent();
            $table->unsignedInteger('viewed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
