<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsRequesterAtProductTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_transfer', function (Blueprint $table) {
          $table->integer('requester_id')->default(1)->after('user_id');
          $table->integer('returned_to')->nullable()->after('requester_id');
          $table->integer('ticket_id')->nullable()->after('returned_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_transfer', function (Blueprint $table) {
            $table->dropColumn('ticket_id');
            $table->dropColumn('returned_to');
            $table->dropColumn('requester_id');
        });
    }
}
