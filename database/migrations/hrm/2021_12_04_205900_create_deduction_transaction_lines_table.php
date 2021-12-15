<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionTransactionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_deduction_transaction_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hrm_transaction_id')->unsigned();
            $table->foreign('hrm_transaction_id')->references('id')->on('hrm_transactions')->onDelete('cascade');
            $table->boolean('is_enabled')->default(false);
            $table->integer('deduction_id')->unsigned();
            $table->integer('divider')->default(0);
            $table->foreign('deduction_id')->references('id')->on('hrm_deductions')->onDelete('cascade');
            $table->decimal('amount', 22, 4)->default(0);
            $table->timestamps();
        });
        Schema::create('hrm_allowance_transaction_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hrm_transaction_id')->unsigned();
            $table->foreign('hrm_transaction_id')->references('id')->on('hrm_transactions')->onDelete('cascade');
            $table->boolean('is_enabled')->default(false);
            $table->integer('allowance_id')->unsigned();
            $table->foreign('allowance_id')->references('id')->on('hrm_allowances')->onDelete('cascade');
            $table->decimal('amount', 22, 4)->default(0);
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
        Schema::dropIfExists('deduction_transaction_lines');
    }
}
