<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queries', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('label')->nullable();

            $table->text('description')->nullable();

            $table->text('query')->nullable();

            $table->boolean('is_query_string')->default(false);

            $table->enum('type', ['Selecionar', 'Inserir', 'Atualizar', 'Deletar'])->default('Selecionar');

            $table->integer('table_id')->unsigned();
            $table->foreign('table_id')->references('id')->on('tables');

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
        Schema::dropIfExists('queries');
    }
}
