<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('document', 20)->nullable();
            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->uuid('uuid')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('client_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->uuid('uuid')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('client_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->uuid('uuid')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('zip');
            $table->string('street');
            $table->string('number')->nullable();
            $table->string('district')->nullable();
            $table->string('complement')->nullable();
            $table->string('reference')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('building_type')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->boolean('is_default')->default(false);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('client_occupations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cpf');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('biometric')->nullable();
            $table->integer('occupation_id')->unsigned();
            $table->foreign('occupation_id')->references('id')->on('client_occupations');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('clients');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('client_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id');
            $table->enum('type', ['file', 'directory'])->default('file');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->uuid('uuid')->unique();
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

        Schema::dropIfExists('client_documents');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('client_occupations');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('client_emails');
        Schema::dropIfExists('client_phones');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('contracts');
    }
}
