<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsAtClientEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_employees', function (Blueprint $table) {
            //$table->dropIndex(['company_id', 'occupation_id']);
            $table->dropColumn('hired_at');
            $table->dropColumn('fired_at');
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
            $table->dropForeign(['occupation_id']);
            $table->dropColumn('occupation_id');
            $table->dropColumn('last_exam');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_employees', function (Blueprint $table) {
            $table->integer('occupation_id')->unsigned()->default(1);
            $table->foreign('occupation_id')->references('id')->on('client_occupations');
            $table->integer('company_id')->unsigned()->default(1);
            $table->foreign('company_id')->references('id')->on('clients');
            $table->date('hired_at')->after('code')->nullable();
            $table->date('last_exam')->after('hired_at')->nullable();
            $table->date('fired_at')->after('last_exam')->nullable();
        });
    }
}
