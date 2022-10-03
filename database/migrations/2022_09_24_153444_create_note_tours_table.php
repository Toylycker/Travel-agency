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
        Schema::create('note_tours', function (Blueprint $table) {
            $table->unsignedBigInteger('note_id');
            $table->foreign('note_id')->references('id')->on('notes')->cascadeOnDelete();
            $table->unsignedBigInteger('tour_id');
            $table->foreign('tour_id')->references('id')->on('tours')->cascadeOnDelete();
            $table->String('status');
            $table->primary(['note_id', 'tour_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_tours');
    }
};
