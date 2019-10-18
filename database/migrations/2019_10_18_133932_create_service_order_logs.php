<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message')->nullable();
            $table->integer('service_order_id')->unsigned();
            $table->foreign('service_order_id')->references('id')->on('service_orders');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('service_order_item_statuses');
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
        Schema::dropIfExists('service_order_logs');
    }
}
