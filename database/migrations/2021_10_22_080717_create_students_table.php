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
            $table->decimal('advance_amount', 22, 4)->default(0);
            $table->integer('campus_id')->unsigned()->nullable();
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->integer('adm_session_id')->unsigned()->nullable();
            $table->foreign('adm_session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->integer('cur_session_id')->unsigned()->nullable();
            $table->foreign('cur_session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->string('admission_no')->unique();
            $table->date('admission_date');
            $table->string('roll_no')->unique();
            $table->integer('adm_class_id')->unsigned();
            $table->foreign('adm_class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->integer('current_class_id')->unsigned();
            $table->foreign('current_class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->integer('adm_class_section_id')->unsigned();
            $table->foreign('adm_class_section_id')->references('id')->on('class_sections')->onDelete('cascade');
            $table->integer('current_class_section_id')->unsigned();
            $table->foreign('current_class_section_id')->references('id')->on('class_sections')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('birth_date');
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('domicile_id')->unsigned()->nullable();
            $table->foreign('domicile_id')->references('id')->on('districts')->onDelete('cascade');
            $table->enum('religion', ['Islam', 'Hinduism', 'Christianity','Sikhism','Buddhism','Secular/Nonreligious/Agnostic/Atheist','Other'])->default('Islam');
            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->string('cnic_no')->nullable();
            $table->enum('blood_group', ['O+', 'O-', 'A+','A-','B+','B-','AB+','AB-'])->nullable();
            $table->string('nationality')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->string('student_image')->nullable();
            $table->string('previous_school_name')->nullable();
            $table->string('last_grade')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('remark')->nullable();
            $table->enum('status', ['active', 'inactive', 'pass_out','struck_up'])->default('active');
            //parent
            $table->string('father_name');
            $table->string('father_phone')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_cnic_no')->nullable();
            //mother
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_cnic_no')->nullable();
            //address
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
            $table->text('std_current_address')->nullable();
            $table->text('std_permanent_address')->nullable();
            /// Miscellaneous
            $table->decimal('student_tuition_fee', 22, 4)->default(0);
            $table->boolean('is_transport')->default(0);
            $table->decimal('student_transport_fee', 22, 4)->default(0);

           
            $table->integer('system_settings_id')->unsigned();
            $table->foreign('system_settings_id')->references('id')->on('system_settings')->onDelete('cascade');
            $table->integer('discount_id')->unsigned()->nullable();
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');

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
