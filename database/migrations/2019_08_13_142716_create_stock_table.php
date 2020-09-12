<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('brands');

            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('model_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->integer('lifetime')->nullable();
            $table->enum('lifetime_type', ['days', 'months', 'years'])->nullable();
            $table->integer('min_stock')->nullable();
            $table->integer('max_stock')->nullable();
            $table->integer('actual_stock')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        Schema::create('stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('equity_registration_code')->nullable();
            $table->date('buyed_at')->nullable();
            $table->enum('status', ['Disponível', 'Reservado', 'Em Uso', 'Em Manutenção', 'Troca', 'Danificado', 'Perdido', 'Descartado'])->default('Disponível');
            $table->enum('localization', ['Almoxarifado','Usuário', 'Departamento', 'Unidade', 'Fornecedor'])->default('Almoxarifado');
            $table->integer('user_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('unity_id')->nullable();
            $table->integer('vendor_id')->nullable();
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
        Schema::dropIfExists('stock');
        Schema::dropIfExists('products');
    }
}
