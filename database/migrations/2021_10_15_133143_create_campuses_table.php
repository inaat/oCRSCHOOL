<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('campus_name');
            $table->string('mobile', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->text('address')->nullable();
            $table->text('registration_code')->nullable();
            $table->date('registration_date')->nullable();
            $table->integer('system_settings_id')->unsigned();
            $table->foreign('system_settings_id')->references('id')->on('system_settings')->onDelete('cascade');
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
        Schema::dropIfExists('schools');
    }
}
