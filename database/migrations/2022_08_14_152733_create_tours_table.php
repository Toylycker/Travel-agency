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
            $table->text('body');
            $table->integer('total_days');
            $table->integer('total_nights');
            $table->unsignedFloat('price')->default(0);
            $table->unsignedInteger('discount_percent')->default(0);
            $table->dateTime('discount_datetime_start')->useCurrent()->nullable();
            $table->dateTime('discount_datetime_end')->useCurrent()->nullable();
            $table->unsignedInteger('viewed')->default(0);
            $table->boolean('recommended')->default(0);
            $table->unsignedInteger('liked')->default(0);
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
