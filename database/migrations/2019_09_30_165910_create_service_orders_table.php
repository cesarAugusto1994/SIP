<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('service_orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('service_order_statuses');

            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('service_order_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('service_order_id')->unsigned();
            $table->foreign('service_order_id')->references('id')->on('service_orders');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');

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
        Schema::dropIfExists('service_order_items');
        Schema::dropIfExists('service_orders');
        Schema::dropIfExists('service_order_statuses');
    }
}
