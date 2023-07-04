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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('name_cn', 30)->nullable();
            $table->string('surname', 30);
            $table->string('email', 30);
            $table->string('phone');
            $table->integer('quantity')->nullable();
            $table->date('arrival')->nullable();
            $table->date('departure')->nullable();
            $table->unsignedBigInteger('tour_id')->nullable();
            $table->foreign('tour_id')->references('id')->on('tours')->nullOnDelete();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->nullOnDelete();
            $table->string('ip')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('applications');
    }
};

$table->unsignedBigInteger('user_id')->nullable();
$table->foreign('user_id')->references('id')->on('users');
$table->unsignedBigInteger('application_id')->nullable();
$table->foreign('application_id')->references('id')->on('applications')->nullOnDelete();
$table->boolean('isRelative')->default(false)->nullable();//defines whether it is user's own application or one of his relatives(friend or family member)
