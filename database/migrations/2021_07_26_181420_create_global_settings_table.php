

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('school_name');
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->text('registration_code')->nullable();
            $table->date('registration_date')->nullable();
            $table->enum('school_type', ['boys', 'girls','boys_and_girls'])->default('boys');
            $table->enum('school_level', ['primary', 'middle','high','inter'])->default('inter');
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->date('start_date')->nullable();
            $table->string('date_format')->default('m/d/Y');
            $table->enum('time_format', [12, 24])->default(24);
            $table->string('time_zone')->default('Asia/Karachi');
            $table->string('start_month', 40);
            $table->integer('biometric')->nullable()->default(0);
            $table->text('biometric_device')->nullable();
            $table->string('is_rtl', 10)->nullable()->default('disabled');
            $table->integer('is_duplicate_fees_invoice')->nullable()->default(0);
            $table->integer('session_id')->unsigned()->nullable()->index('session_id');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->string('cron_secret_key', 100);
            $table->enum('currency_symbol_placement', ['before', 'after'])->default('before');
            $table->boolean('attendence_type')->default(0);
            $table->string('image', 100)->nullable();
            $table->string('admin_logo');
            $table->string('admin_small_logo');
            $table->integer('fee_due_days')->nullable()->default(0);
            $table->boolean('adm_auto_insert')->default(1);
            $table->string('adm_prefix', 50)->default('ssadm19/20');
            $table->string('adm_start_from', 11);
            $table->integer('adm_no_digit')->default(6);
            $table->boolean('adm_update_status')->default(0);
            $table->integer('staffid_auto_insert')->default(1);
            $table->string('staffid_prefix', 100)->default('staffss/19/20');
            $table->string('staffid_start_from', 50);
            $table->integer('staffid_no_digit')->default(6);
            $table->integer('staffid_update_status')->default(0);
            $table->string('is_active')->nullable()->default(0);
            $table->integer('online_admission')->nullable()->default(0);
            $table->boolean('is_blood_group')->default(1);
            $table->boolean('is_student_house')->default(1);
            $table->boolean('roll_no')->default(1);
            $table->boolean('category')->default(1);
            $table->boolean('religion')->default(1);
            $table->boolean('cast')->default(1);
            $table->boolean('mobile_no')->default(1);
            $table->boolean('student_email')->default(1);
            $table->boolean('admission_date')->default(1);
            $table->boolean('lastname')->default(1);
            $table->boolean('middlename')->default(1);
            $table->boolean('student_photo')->default(1);
            $table->boolean('student_height')->default(1);
            $table->boolean('student_weight')->default(1);
            $table->boolean('measurement_date')->default(1);
            $table->boolean('father_name')->default(1);
            $table->boolean('father_phone')->default(1);
            $table->boolean('father_occupation')->default(1);
            $table->boolean('father_pic')->default(1);
            $table->boolean('mother_name')->default(1);
            $table->boolean('mother_phone')->default(1);
            $table->boolean('mother_occupation')->default(1);
            $table->boolean('mother_pic')->default(1);
            $table->boolean('guardian_name')->default(1);
            $table->boolean('guardian_relation')->default(1);
            $table->boolean('guardian_phone')->default(1);
            $table->boolean('guardian_email')->default(1);
            $table->boolean('guardian_pic')->default(1);
            $table->boolean('guardian_occupation')->default(1);
            $table->boolean('guardian_address')->default(1);
            $table->boolean('current_address')->default(1);
            $table->boolean('permanent_address')->default(1);
            $table->boolean('route_list')->default(1);
            $table->boolean('hostel_id')->default(1);
            $table->boolean('bank_account_no')->default(1);
            $table->boolean('ifsc_code')->default(1);
            $table->boolean('bank_name')->default(1);
            $table->boolean('national_identification_no')->default(1);
            $table->boolean('local_identification_no')->default(1);
            $table->boolean('rte')->default(1);
            $table->boolean('previous_school_details')->default(1);
            $table->boolean('student_note')->default(1);
            $table->boolean('upload_documents')->default(1);
            $table->boolean('staff_designation')->default(1);
            $table->boolean('staff_department')->default(1);
            $table->boolean('staff_last_name')->default(1);
            $table->boolean('staff_father_name')->default(1);
            $table->boolean('staff_mother_name')->default(1);
            $table->boolean('staff_date_of_joining')->default(1);
            $table->boolean('staff_phone')->default(1);
            $table->boolean('staff_emergency_contact')->default(1);
            $table->boolean('staff_marital_status')->default(1);
            $table->boolean('staff_photo')->default(1);
            $table->boolean('staff_current_address')->default(1);
            $table->boolean('staff_permanent_address')->default(1);
            $table->boolean('staff_qualification')->default(1);
            $table->boolean('staff_work_experience')->default(1);
            $table->boolean('staff_note')->default(1);
            $table->boolean('staff_epf_no')->default(1);
            $table->boolean('staff_basic_salary')->default(1);
            $table->boolean('staff_contract_type')->default(1);
            $table->boolean('staff_work_shift')->default(1);
            $table->boolean('staff_work_location')->default(1);
            $table->boolean('staff_leaves')->default(1);
            $table->boolean('staff_account_details')->default(1);
            $table->boolean('staff_social_media')->default(1);
            $table->boolean('staff_upload_documents')->default(1);
            $table->text('mobile_api_url');
            $table->string('app_primary_color_code', 20)->nullable();
            $table->string('app_secondary_color_code', 20)->nullable();
            $table->string('app_logo', 250)->nullable();
            $table->boolean('student_profile_edit')->default(0);
            $table->string('start_week', 10);
            $table->boolean('my_question')->default(0);
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
        Schema::dropIfExists('global_settings');
    }
}

