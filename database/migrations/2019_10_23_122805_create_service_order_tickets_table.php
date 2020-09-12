<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_tickets', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('service_order_id')->unsigned();
            $table->foreign('service_order_id')->references('id')->on('service_orders');

            $table->integer('ticket_type_id')->unsigned();
            $table->foreign('ticket_type_id')->references('id')->on('ticket_types');

            $table->integer('ticket_id')->nullable();

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
        Schema::dropIfExists('service_order_tickets');
    }
}
