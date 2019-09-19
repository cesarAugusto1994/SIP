<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWithdrawalAtDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_order', function (Blueprint $table) {
            $table->boolean('withdrawal_by_client')->default(false)->after('status_id');
            $table->boolean('charge_delivery')->default(true)->after('withdrawal_by_client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_order', function (Blueprint $table) {
            $table->dropColumn('charge_delivery');
            $table->dropColumn('withdrawal_by_client');
        });
    }
}
