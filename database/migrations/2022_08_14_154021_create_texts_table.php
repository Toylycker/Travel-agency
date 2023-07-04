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
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->integer('text_number');
            $table->string('title', 100);
            $table->string('title_cn', 100)->nullable();
            $table->text('body');
            $table->text('body_cn')->nullable();
            $table->unsignedBigInteger('textable_id');
            $table->string('textable_type');
            $table->index(['textable_id', 'textable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('texts');
    }
};
