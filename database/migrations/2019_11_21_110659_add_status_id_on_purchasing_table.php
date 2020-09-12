<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusIdOnPurchasingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchasings', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->integer('status_id')->default(1)->after('observations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchasings', function (Blueprint $table) {
            $table->dropColumn('status_id');
            $table->enum('status', ['Aberta', 'Em Andamento', 'Aprovada', 'Rejeitada'])->default('Aberta');
        });
    }
}
