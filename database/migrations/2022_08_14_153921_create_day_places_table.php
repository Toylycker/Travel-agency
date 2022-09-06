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
        Schema::create('day_places', function (Blueprint $table) {
            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id')->references('id')->on('days')->cascadeOnDelete();
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')->references('id')->on('places')->cascadeOnDelete();
            $table->primary(['day_id', 'place_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_places');
    }
};
