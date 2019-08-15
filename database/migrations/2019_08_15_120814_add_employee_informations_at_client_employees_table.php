<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeInformationsAtClientEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_employees', function(Blueprint $table) {
            $table->date('birth')->nullable();
            $table->date('last_exam')->nullable();
            $table->date('fired_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_employees', function(Blueprint $table) {
            $table->dropColumn('birth');
            $table->dropColumn('last_exam');
            $table->dropColumn('fired_at');
        });
    }
}
