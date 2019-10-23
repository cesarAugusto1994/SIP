<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTrainingCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_training_courses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');

            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');

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
        Schema::dropIfExists('service_training_courses');
    }
}
