<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsAtServiceOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_items', function (Blueprint $table) {
            $table->integer('status_id')->unsigned()->default(1)->after('service_id');
            $table->foreign('status_id')->references('id')->on('service_order_item_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_order_items', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
}
