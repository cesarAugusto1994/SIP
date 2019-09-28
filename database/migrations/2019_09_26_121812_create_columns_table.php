<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('label')->nullable();
            $table->string('type');

            $table->integer('table_id')->unsigned();
            $table->foreign('table_id')->references('id')->on('tables');

            $table->integer('table_reference_id')->nullable();
            $table->integer('format_id')->nullable();

            $table->boolean('is_primary_key')->default(false);
            $table->boolean('is_label')->default(false);
            $table->boolean('show')->default(true);

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
        Schema::dropIfExists('columns');
    }
}
