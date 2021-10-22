<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('admission_no')->unique();
            $table->string('roll_no')->unique();
            $table->date('admission_date');
            $table->date('as_on_date');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('caste');
            $table->string('cnic_num');
            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->string('nationality')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('std_current_address')->nullable();
            $table->text('std_permanent_address')->nullable();
            $table->enum('status', ['active', 'inactive', 'pass_out'])->default('active');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('religion', ['Islam', 'Hinduism', 'Christianity','Sikhism','Buddhism','Secular/Nonreligious/Agnostic/Atheist','Other'])->default('Islam');
            $table->enum('blood_group', ['O+', 'O-', 'A+','A-','B+','B-','AB+','AB-'])->nullable();
            //parent
            $table->string('father_name');
            $table->string('father_phone')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_cnic_no')->nullable();
            $table->string('father_photo')->nullable();
            //mother
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_cnic_no')->nullable();
            $table->string('mother_photo')->nullable();
            $table->integer('system_settings_id')->unsigned();
            $table->foreign('system_settings_id')->references('id')->on('system_settings')->onDelete('cascade');
            $table->integer('admission_class_id')->unsigned();
            $table->foreign('admission_class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->integer('current_class_id')->unsigned();
            $table->foreign('current_class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->integer('admission_class_section_id')->unsigned();
            $table->foreign('admission_class_section_id')->references('id')->on('class_sections')->onDelete('cascade');
            $table->integer('current_class_section_id')->unsigned();
            $table->foreign('current_class_section_id')->references('id')->on('class_sections')->onDelete('cascade');
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('students');
    }
}
