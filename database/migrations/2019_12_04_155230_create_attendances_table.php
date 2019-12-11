<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees');

            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->integer('status_id')->unsigned()->default(1);
            $table->foreign('status_id')->references('id')->on('attendance_statuses');

            $table->date('delivery_date');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('attendance_document_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('attendance_document_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('attendance_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attendance_id')->unsigned();
            $table->foreign('attendance_id')->references('id')->on('attendances');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('attendance_document_types');
            $table->integer('status_id')->unsigned()->default(1);
            $table->foreign('status_id')->references('id')->on('attendance_document_statuses');
            $table->date('delivery_date')->nullable();
            $table->integer('transfered_to')->nullable();
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('attendance_protocol_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('attendance_protocols', function (Blueprint $table) {

            $table->increments('id');

            $table->string('description')->nullable();
            $table->string('observations')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('status_id')->unsigned()->default(1);
            $table->foreign('status_id')->references('id')->on('attendance_protocol_statuses');

            $table->datetime('delivery_date')->nullable();
            $table->datetime('receiving_date')->nullable();

            $table->enum('period_day', ['DIA INTEIRO', 'MANHÃ', 'TARDE'])->default('DIA INTEIRO');

            $table->integer('verified_by')->unsigned();
            $table->foreign('verified_by')->references('id')->on('users');

            $table->datetime('verified_at')->nullable();
            $table->uuid('uuid')->unique();

            $table->timestamps();

        });

        Schema::create('attendance_protocol_attendances', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('protocol_id')->unsigned();
            $table->foreign('protocol_id')->references('id')->on('attendance_protocols');

            $table->integer('attendance_id')->unsigned();
            $table->foreign('attendance_id')->references('id')->on('attendances');

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
        Schema::dropIfExists('attendance_protocol_attendances');
        Schema::dropIfExists('attendance_protocols');
        Schema::dropIfExists('attendance_protocol_statuses');
        Schema::dropIfExists('attendance_documents');
        Schema::dropIfExists('attendance_document_statuses');
        Schema::dropIfExists('attendance_document_types');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('attendance_statuses');
    }
}
