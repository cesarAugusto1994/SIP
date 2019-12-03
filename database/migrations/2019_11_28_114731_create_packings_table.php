<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_packings', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['Pendente', 'Em Rota', 'Finalizado'])->default('Pendente');
            $table->date('delivery_date');
            $table->integer('delivered_by')->unsigned();
            $table->foreign('delivered_by')->references('id')->on('users');
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('delivery_packings');
    }
}
