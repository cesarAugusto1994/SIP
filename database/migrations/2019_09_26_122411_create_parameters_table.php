<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->enum('type', ['Texto', 'Entidade'])->default('Texto');

            $table->text('query')->nullable();
            $table->string('parameter_id')->nullable();

            $table->integer('query_id')->unsigned();
            $table->foreign('query_id')->references('id')->on('queries');

            $table->integer('column_id')->unsigned();
            $table->foreign('column_id')->references('id')->on('columns');

            $table->integer('table_id')->nullable();

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
        Schema::dropIfExists('parameters');
    }
}
