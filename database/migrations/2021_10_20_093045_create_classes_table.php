<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->decimal('tuition_fee', 22, 4)->default(0);
            $table->decimal('admission_fee', 22, 4)->default(0);
           $table->decimal('transport_fee', 22, 4)->default(0);
           $table->decimal('security_fee', 22, 4)->default(0);
           $table->decimal('prospectus_fee', 22, 4)->default(0);
            $table->integer('system_settings_id')->unsigned();
            $table->foreign('system_settings_id')->references('id')->on('system_settings')->onDelete('cascade');
            $table->integer('campus_id')->unsigned()->nullable();
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->integer('class_level_id')->unsigned()->nullable();
            $table->foreign('class_level_id')->references('id')->on('class_levels')->onDelete('cascade');
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
        Schema::dropIfExists('classes');
    }
}
