<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('vehicle_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('model');
            $table->string('brand');
            $table->integer('year');
            $table->date('bought_at')->nullable();
            $table->date('last_maintenance')->nullable();
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('vehicle_status');
            $table->boolean('active')->default(true);
            $table->date('inactivated_at')->nullable();
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('vehicle_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('vehicle_id')->unsigned();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->integer('status_id')->nullable();
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('fleet_schedule_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('fleet_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('users');
            $table->integer('vehicle_id')->unsigned();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('fleet_schedule_status');
            $table->integer('vacancies')->nullable();
            $table->datetime('start');
            $table->datetime('end')->nullable();
            $table->text('reason')->nullable();
            $table->string('ride_to')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('approved')->default(false);
            $table->integer('approved_by')->nullable();
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('fleet_schedule_guests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id')->unsigned()->index();
            $table->foreign('schedule_id')->references('id')->on('fleet_schedules');
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
        Schema::dropIfExists('fleet_schedules');
        Schema::dropIfExists('fleet_schedule_status');
        Schema::dropIfExists('vehicle_logs');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('vehicle_status');
    }
}
