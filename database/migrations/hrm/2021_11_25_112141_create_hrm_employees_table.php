<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_employees', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('campus_id')->unsigned()->nullable();
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
			$table->string('employeeID', 20)->unique();
			$table->string('first_name');
            $table->string('last_name');
			$table->string('email', 150)->unique();
			$table->string('password', 100);
			$table->enum('gender',['male','female','other']);
			$table->string('father_name', 100);
			$table->string('mobile_no', 20);
			$table->decimal('basic_salary', 22, 4)->nullable();
		    $table->string('pay_period')->nullable();
		    $table->string('pay_cycle')->nullable();
			$table->date('birth_date')->nullable();
			$table->integer('department_id')->unsigned()->nullable();
			$table->integer('designation_id')->unsigned()->nullable();
			$table->integer('education_id')->unsigned()->nullable();
			$table->date('joining_date')->nullable();
			$table->string('employee_image')->default('default.png')->nullable();
			$table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->integer('province_id')->unsigned()->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->integer('district_id')->unsigned()->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->integer('region_id')->unsigned()->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
			$table->text('current_address')->nullable();
			$table->text('permanent_address')->nullable();
			$table->string('nationality')->nullable();
			$table->string('mother_tongue')->nullable();
			$table->integer('annual_leave')->default(0);
			$table->enum('status',['active','inactive','resign'])->default('active');
			$table->enum('religion', ['Islam', 'Hinduism', 'Christianity','Sikhism','Buddhism','Secular/Nonreligious/Agnostic/Atheist','Other'])->default('Islam');
            $table->string('cnic_no')->nullable();
            $table->text('remark')->nullable();
            $table->text('resign_remark')->nullable();
            $table->enum('blood_group', ['O+', 'O-', 'A+','A-','B+','B-','AB+','AB-'])->nullable();
			$table->longText('bank_details')->nullable();
			$table->dateTime('last_login')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->date('exit_date')->nullable();
			$table->foreign('department_id')
			      ->references('id')->on('hrm_departments')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');
			$table->foreign('designation_id')
			      ->references('id')->on('hrm_designations')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');
			$table->foreign('education_id')
			      ->references('id')->on('hrm_education')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');
			$table->string('reset_code')->nullable();
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
        Schema::dropIfExists('hrm_employees');
    }
}
