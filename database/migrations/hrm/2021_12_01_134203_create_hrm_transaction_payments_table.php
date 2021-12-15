<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmTransactionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_transaction_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hrm_transaction_id')->unsigned()->nullable();
            $table->foreign('hrm_transaction_id')->references('id')->on('hrm_transactions')->onDelete('cascade');
            $table->boolean('is_return')->default(false)->comment('Used during adjustment to return the change');
            $table->integer('session_id')->unsigned()->nullable();
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->decimal('discount_amount', 22, 4)->default(0);
            $table->decimal('amount', 22, 4)->default(0);
            $table->enum('method', ['cash', 'card', 'cheque', 'bank_transfer', 'other','advance_pay','student_advance_amount']);
            $table->string('transaction_no')->nullable();
            $table->string('card_transaction_number')->nullable();
            $table->string('card_number')->nullable();
            $table->enum('card_type', ['visa', 'master'])->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_month')->nullable();
            $table->string('card_year')->nullable();
            $table->string('card_security', 5)->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->dateTime('paid_on')->nullable();
            $table->integer('created_by');
            $table->integer('payment_for')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('payment_ref_no')->nullable();
            $table->integer('account_id')->nullable();
            $table->string('note')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
        Schema::table('account_transactions', function (Blueprint $table) {
            $table->integer('hrm_transaction_payment_id')->unsigned()->nullable()->after('transaction_id');
            $table->foreign('hrm_transaction_payment_id')->references('id')->on('hrm_transaction_payments')->onDelete('cascade');
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_transaction_payments');
    }
}
