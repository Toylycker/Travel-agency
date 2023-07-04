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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->nullable()->default(1);
            $table->string('title', 100)->default('text');
            $table->string('main_image', 100)->nullable();
            $table->text('body')->nullable();
            $table->text('body_cn')->nullable();
            $table->integer('viewed')->nullable();
            $table->boolean('recommended')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
