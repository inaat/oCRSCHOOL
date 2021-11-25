<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeTransactionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_transaction_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fee_transaction_id')->unsigned()->nullable();
            $table->foreign('fee_transaction_id')->references('id')->on('fee_transactions')->onDelete('cascade');
            $table->integer('system_settings_id')->unsigned();
            $table->foreign('system_settings_id')->references('id')->on('system_settings')->onDelete('cascade');
           
            $table->boolean('is_return')->default(false)->comment('Used during adjustment to return the change');
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

        // DB::statement("ALTER TABLE transaction_payments MODIFY COLUMN transaction_id INT(11) UNSIGNED DEFAULT NULL");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_transaction_payments');
    }
}
