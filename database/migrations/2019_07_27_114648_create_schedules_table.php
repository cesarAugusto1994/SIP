<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('localization')->nullable();
            $table->datetime('start')->nullable();
            $table->datetime('end')->nullable();
            $table->boolean('all_day')->default(false);
            $table->integer('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('schedule_types');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('schedule_guests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id')->unsigned()->index();
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('uuid')->unique();
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
        Schema::dropIfExists('schedules');
    }
}
