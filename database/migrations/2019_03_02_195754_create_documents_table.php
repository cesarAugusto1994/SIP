<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('link')->nullable();
            $table->string('filename')->nullable();
            $table->string('extension')->nullable();
            $table->string('annotations')->nullable();
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('document_types');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('delivery_document_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('delivery_document_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('price', 12,2)->default(0.00);
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('delivery_document_type_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('document_types');
            $table->float('old_price', 12,2)->default(0.00);
            $table->float('new_price', 12,2)->default(0.00);
            $table->integer('updated_by')->unsigned();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('delivery_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('annotations')->nullable();
            $table->string('reference')->nullable();
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->integer('employee_id')->nullable();
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('delivery_document_statuses');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('delivery_document_types');
            $table->float('amount', 12,2)->default(0.00);
            $table->float('extra_amount', 12,2)->default(0.00);
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
        Schema::dropIfExists('delivery_documents');
        Schema::dropIfExists('delivery_document_type_log');
        Schema::dropIfExists('delivery_document_types');
        Schema::dropIfExists('delivery_document_statuses');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('document_types');
    }
}
