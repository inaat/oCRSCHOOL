<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeTransactionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_transaction_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fee_transaction_id')->unsigned();
            $table->foreign('fee_transaction_id')->references('id')->on('fee_transactions')->onDelete('cascade');
            $table->integer('fee_head_id')->unsigned();
            $table->foreign('fee_head_id')->references('id')->on('fee_heads')->onDelete('cascade');
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
        Schema::dropIfExists('fee_transaction_lines');
    }
}
