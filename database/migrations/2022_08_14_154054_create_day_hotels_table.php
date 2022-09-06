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
        Schema::create('day_hotels', function (Blueprint $table) {
            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id')->references('id')->on('days')->cascadeOnDelete();
            $table->unsignedBigInteger('hotel_id');
            $table->foreign('hotel_id')->references('id')->on('hotels')->cascadeOnDelete();
            $table->primary(['day_id', 'hotel_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_hotels');
    }
};
