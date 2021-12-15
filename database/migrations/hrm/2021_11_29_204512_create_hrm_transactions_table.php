<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campus_id')->unsigned();
            $table->foreign('campus_id')->references('id')->on('campuses');
            $table->integer('session_id')->unsigned();
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->string('payroll_group_name')->nullable();
            $table->enum('type', ['opening_balance', 'pay_roll','expense']);
            $table->enum('status', ['pending','final']);
            $table->enum('payment_status', ['paid', 'due', 'partial']);
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('hrm_employees')->onDelete('cascade');
            $table->string('ref_no')->nullable();
            $table->dateTime('transaction_date');
            $table->enum('month',[1,2,3,4,5,6,7,8,9,10,11,12]);
            $table->decimal('basic_salary', 22, 4)->default(0);
            $table->decimal('allowances_amount', 22, 4)->default(0);
            $table->decimal('deductions_amount', 22, 4)->default(0);
            $table->decimal('final_total', 22, 4)->default(0);
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->text('allowances')->nullable();
            $table->text('deductions')->nullable();
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
        Schema::dropIfExists('hrm_transactions');
    }
}
