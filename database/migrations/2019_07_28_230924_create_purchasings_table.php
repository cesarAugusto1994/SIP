<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('purchasings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('motive')->nullable();
            $table->text('observations')->nullable();
            $table->enum('status', ['Aberta', 'Em Andamento', 'Aprovada', 'Rejeitada'])->default('Aberta');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('delivery_forecast')->nullable();
            $table->date('delivery_at')->nullable();
            $table->date('buyed_at')->nullable();
            $table->integer('approved_by')->nullable();
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('purchasing_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchasing_id')->unsigned()->index();
            $table->foreign('purchasing_id')->references('id')->on('purchasings');
            $table->integer('quantity')->default(1);
            $table->enum('unit', ['Unidade', 'Serviço', 'Peça', 'Kilo', 'Litro', 'Metro', 'Caixa'])->default('Unidade');
            $table->string('description')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('approved_by')->nullable();
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
        Schema::dropIfExists('purchasings');
    }
}
