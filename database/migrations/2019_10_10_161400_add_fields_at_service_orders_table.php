<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsAtServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_items', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('service_id');
            $table->string('observation')->nullable()->after('quantity');
            $table->date('deadline')->nullable()->after('observation');
            $table->integer('user_id')->nullable()->after('deadline');
            $table->float('original_value', 12,2)->default(0.00)->after('user_id');
            $table->float('value', 12,2)->default(0.00)->after('original_value');
        });

        Schema::table('service_orders', function (Blueprint $table) {
            $table->integer('contact_id')->nullable()->after('status_id');
            $table->float('amount', 12,2)->nullable()->after('contact_id');
            $table->float('input_value', 12,2)->nullable()->after('amount');
            $table->date('due_date')->nullable()->after('input_value');
            $table->integer('installment_quantity')->default(1)->after('due_date');
            $table->date('installment_date')->nullable()->after('installment_quantity');
            $table->float('installment_value', 12,2)->nullable()->after('installment_date');

            $table->float('discount', 12,2)->nullable()->after('installment_value');

            $table->date('client_data_solicitation_date')->nullable()->after('installment_value');
            $table->date('client_feedback_date')->nullable()->after('client_data_solicitation_date');
            $table->date('release_date')->nullable()->after('client_feedback_date');
            $table->boolean('completed_service')->default(false)->after('release_date');

            $table->text('observation')->nullable()->after('completed_service');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_order_items', function (Blueprint $table) {
            $table->dropColumn('value');
            $table->dropColumn('original_value');
            $table->dropColumn('user_id');
            $table->dropColumn('deadline');
            $table->dropColumn('observation');
            $table->dropColumn('quantity');
        });

        Schema::table('service_orders', function (Blueprint $table) {

            $table->dropColumn('observation');
            $table->dropColumn('completed_service');
            $table->dropColumn('release_date');
            $table->dropColumn('client_feedback_date');
            $table->dropColumn('client_data_solicitation_date');

            $table->dropColumn('contact_id');
            $table->dropColumn('discount');
            $table->dropColumn('installment_quantity');
            $table->dropColumn('installment_value');
            $table->dropColumn('installment_date');
            $table->dropColumn('due_date');
            $table->dropColumn('input_value');
            $table->dropColumn('amount');
        });
    }
}
