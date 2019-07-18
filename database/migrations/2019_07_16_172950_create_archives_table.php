<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('path');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('parent_id')->nullable();
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('folder_group_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('folder_id')->unsigned()->index();
            $table->foreign('folder_id')->references('id')->on('folders');
            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')->on('departments');
            $table->boolean('read')->default(false);
            $table->boolean('edit')->default(false);
            $table->boolean('delete')->default(false);
            $table->boolean('share')->default(false);
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('folder_user_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('folder_id')->unsigned()->index();
            $table->foreign('folder_id')->references('id')->on('folders');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('read')->default(false);
            $table->boolean('edit')->default(false);
            $table->boolean('delete')->default(false);
            $table->boolean('share')->default(false);
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('folder_id')->unsigned()->index();
            $table->foreign('folder_id')->references('id')->on('folders');
            $table->string('filename');
            $table->string('path');
            $table->string('size');
            $table->string('type');
            $table->text('content');
            $table->string('extension');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('archive_group_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('archive_id')->unsigned()->index();
            $table->foreign('archive_id')->references('id')->on('archives');
            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')->on('departments');
            $table->boolean('read')->default(false);
            $table->boolean('delete')->default(false);
            $table->boolean('share')->default(false);
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('archive_user_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('archive_id')->unsigned()->index();
            $table->foreign('archive_id')->references('id')->on('archives');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('read')->default(false);
            $table->boolean('delete')->default(false);
            $table->boolean('share')->default(false);
            $table->uuid('uuid');
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
        Schema::dropIfExists('archives');
    }
}
