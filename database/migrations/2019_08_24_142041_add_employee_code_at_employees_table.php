<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeCodeAtEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_employees', function (Blueprint $table) {
              $table->string('code')->after('name')->nullable();
              $table->date('hired_at')->after('code')->nullable();
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
            $table->dropColumn('hired_at');
            $table->dropColumn('code');
        });
    }
}
