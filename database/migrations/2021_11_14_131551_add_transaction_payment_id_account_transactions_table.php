<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionPaymentIdAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_transactions', function (Blueprint $table) {
            $table->integer('transaction_payment_id')->unsigned()->nullable()->after('transaction_id');
            $table->foreign('transaction_payment_id')->references('id')->on('fee_transaction_payments')->onDelete('cascade');
        });
        Schema::table('fee_transaction_payments', function (Blueprint $table) {
            $table->integer('session_id')->unsigned()->nullable()->after('system_settings_id');
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
