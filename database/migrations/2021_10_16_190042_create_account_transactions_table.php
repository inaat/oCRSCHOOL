<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('account_id');
            $table->enum('type', ['debit', 'credit']);
            $table->enum('sub_type', ['opening_balance', 'fund_transfer', 'deposit' ,'debit'])->nullable();
            $table->decimal('amount', 22, 4);
            $table->string('reff_no')->nullable();
            $table->dateTime('operation_date');
            $table->integer('created_by');
            $table->integer('transaction_id')->nullable();
            // $table->integer('transaction_payment_id')->nullable();
            $table->integer('transfer_transaction_id')->nullable();
            $table->text('note')->nullable();
            
            $table->softDeletes();
            $table->timestamps();

            $table->index('account_id');
            $table->index('transaction_id');
            $table->index('transaction_payment_id');
            $table->index('transfer_transaction_id');
            $table->index('created_by');
            $table->index('type');
            $table->index('sub_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_transactions');
    }
}
