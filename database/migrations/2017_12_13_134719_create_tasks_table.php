<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->enum('time_type', ['day', 'hour', 'minute'])->default('hour');
            $table->integer('time');
            $table->dateTime('begin')->nullable();
            $table->dateTime('end')->nullable();
            $table->enum('frequency', ['Exporadicamente', 'Diariamente', 'Semanalmente', 'Mensalmente'])->default('Exporadicamente');
            $table->integer('spent_time')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('severity', [1,2,3,4,5])->default(1);
            $table->enum('urgency', [1,2,3,4,5])->default(1);
            $table->enum('trend', [1,2,3,4,5])->default(1);
            $table->integer('ticket_id')->nullable();
            $table->integer('requester_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('mapper_id')->nullable();

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('task_status');

            $table->integer('sponsor_id')->unsigned();
            $table->foreign('sponsor_id')->references('id')->on('users');

            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('task_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('task_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->string('path');
            $table->string('size')->default(0);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('task_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('task_status');
            $table->text('message');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('task_delays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->text('message');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('task_pauses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->text('message');
            $table->datetime('begin');
            $table->datetime('end')->nullable();
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
        Schema::dropIfExists('task_pauses');
        Schema::dropIfExists('task_delays');
        Schema::dropIfExists('task_logs');
        Schema::dropIfExists('task_archives');
        Schema::dropIfExists('task_messages');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_status');
    }
}
