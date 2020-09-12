<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_addresses', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('service_order_id')->unsigned();
          $table->foreign('service_order_id')->references('id')->on('service_orders');
          $table->integer('client_id')->unsigned();
          $table->foreign('client_id')->references('id')->on('clients');
          $table->integer('address_id')->unsigned();
          $table->foreign('address_id')->references('id')->on('client_addresses');
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
        Schema::dropIfExists('service_order_addresses');
    }
}
