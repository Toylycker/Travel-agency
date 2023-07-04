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
            $table->string('name_cn')->nullable();
            $table->text('body')->nullable();
            $table->text('body_cn')->nullable();
            $table->integer('room_quan')->default(1);
            $table->unsignedBigInteger('hotel_id')->index();
            $table->foreign('hotel_id')->references('id')->on('hotels')->cascadeOnDelete();
            $table->unsignedFloat('price')->default(100.0);
            $table->unsignedInteger('discount_percent')->default(0)->nullable();
            $table->dateTime('discount_datetime_start')->useCurrent()->nullable();;
            $table->dateTime('discount_datetime_end')->useCurrent()->nullable();;
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
