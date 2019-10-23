<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTicketTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_ticket_types', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');

            $table->integer('ticket_type_id')->unsigned();
            $table->foreign('ticket_type_id')->references('id')->on('ticket_types');

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
        Schema::dropIfExists('service_ticket_types');
    }
}
