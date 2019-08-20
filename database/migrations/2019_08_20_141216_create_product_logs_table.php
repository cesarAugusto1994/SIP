<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock', function (Blueprint $table) {
            $table->string('serial')->after('equity_registration_code')->nullable();
        });

        Schema::create('stock_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_id')->unsigned();
            $table->foreign('stock_id')->references('id')->on('stock');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('message');
            $table->enum('status', ['Disponível', 'Em Uso', 'Em Manutenção', 'Troca', 'Danificado', 'Perdido', 'Descartado'])->default('Disponível');
            $table->enum('localization', ['Almoxarifado','Usuário', 'Departamento', 'Unidade', 'Fornecedor'])->default('Almoxarifado');
            $table->integer('target_id')->nullable();
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
        Schema::dropIfExists('stock_logs');

        Schema::table('stock', function (Blueprint $table) {
            $table->dropColumn('serial');
        });
    }
}
