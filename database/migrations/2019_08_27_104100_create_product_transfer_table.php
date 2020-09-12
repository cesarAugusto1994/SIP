<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transfer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('description');
            $table->enum('status', ['Pendente', 'Autorizado', 'Em Uso', 'Negado', 'Devolvido'])->default('Pendente');
            $table->enum('localization', ['Almoxarifado', 'Usuário', 'Departamento', 'Unidade', 'Fornecedor'])->default('Almoxarifado');
            $table->integer('target_id')->nullable();
            $table->string('term_path')->nullable();
            $table->date('scheduled_to')->nullable();
            $table->date('withdrawn_at')->nullable();
            $table->date('returned_at')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('product_transfer_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_id')->unsigned();
            $table->foreign('stock_id')->references('id')->on('stock');
            $table->integer('transfer_id')->unsigned();
            $table->foreign('transfer_id')->references('id')->on('product_transfer');
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
        Schema::dropIfExists('product_transfer_item');
        Schema::dropIfExists('product_transfer');
    }
}
