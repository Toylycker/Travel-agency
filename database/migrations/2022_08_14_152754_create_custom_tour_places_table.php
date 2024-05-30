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
        Schema::create('custom_tour_places', function (Blueprint $table) {
            $table->unsignedBigInteger('place_id')->index();
            $table->foreign('place_id')->references('id')->on('places')->cascadeOnDelete();
            $table->unsignedBigInteger('custom_tour_id')->index();
            $table->foreign('custom_tour_id')->references('id')->on('custom_tours')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_tour_places');
    }
};
