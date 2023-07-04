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
        Schema::create('application_processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id')->index();
            $table->foreign('application_id')->references('id')->on('applications')->cascadeOnDelete();
            $table->unsignedBigInteger('process_id')->index();
            $table->foreign('process_id')->references('id')->on('processes')->cascadeOnDelete();
            $table->string('status', 100);
            $table->string('status_cn', 100)->nullable();
            $table->text('comment')->nullable();
            $table->text('comment_cn')->nullable();
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
        Schema::dropIfExists('application_processes');
    }
};
