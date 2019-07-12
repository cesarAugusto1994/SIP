<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_folders', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('full_name')->nullable();
            $table->string('path')->nullable();

            $table->string('delimiter')->default('/');

            $table->boolean('no_inferiors')->default(false);
            $table->boolean('no_select')->default(false);
            $table->boolean('marked')->default(false);
            $table->boolean('has_children')->default(false);
            $table->boolean('referal')->default(false);

            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('folder_id')->unsigned()->index();
            $table->foreign('folder_id')->references('id')->on('email_folders');

            $table->string('message_id')->unique()->index();
            $table->string('message_no')->index();

            $table->string('subject');
            $table->string('references')->nullable();
            $table->datetime('date');
            $table->string('in_reply_to')->nullable();

            $table->integer('msglist')->default(0);
            $table->integer('uid')->default(0);
            $table->integer('msgn')->default(0);

            $table->string('folder_path')->nullable();
            $table->integer('fetch_options')->default(0);
            $table->boolean('fetch_body')->default(false);
            $table->boolean('fetch_attachment')->default(false);
            $table->boolean('fetch_flags')->default(false);

            $table->integer('priority')->default(0);

            $table->text('header');
            $table->text('header_info')->nullable();
            $table->text('raw_body')->nullable();
            $table->text('text');
            $table->text('html');

            $table->boolean('flag_recent')->default(false);
            $table->boolean('flag_flagged')->default(false);
            $table->boolean('flag_answered')->default(false);
            $table->boolean('flag_deleted')->default(false);
            $table->boolean('flag_seen')->default(false);
            $table->boolean('flag_draft')->default(false);

            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('email_attachments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails');

            $table->text('attechment_id')->nullable();
            $table->string('name');

            $table->text('content');
            $table->string('type');
            $table->string('content_type');
            $table->text('part_number')->nullable();
            $table->text('disposition')->nullable();
            $table->text('img_src')->nullable();

            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('email_contacts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('personal');
            $table->string('mailbox');
            $table->string('host');
            $table->string('mail');
            $table->string('full');
            $table->boolean('active')->default(true);
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('email_from', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails');
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('email_contacts');
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('email_to', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails');
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('email_contacts');
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('email_cc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails');
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('email_contacts');
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('email_bcc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails');
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('email_contacts');
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('email_reply_to', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails');
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('email_contacts');
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('email_sender', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails');
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('email_contacts');
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
        Schema::dropIfExists('emails');
    }
}
