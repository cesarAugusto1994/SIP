<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldPresenceOnScheduleGuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_guests', function (Blueprint $table) {
            $table->boolean('accept')->default(false);
            $table->datetime('read_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_guests', function (Blueprint $table) {
            $table->dropColumn('accept');
            $table->dropColumn('read_at');
        });
    }
}
