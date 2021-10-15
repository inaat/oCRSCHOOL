<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('org_name');
            $table->string('org_address');
            $table->string('org_contact_number');
            $table->string('org_logo');
            $table->string('org_favicon');
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->enum('currency_symbol_placement', ['before', 'after'])->default('before');
            $table->date('start_date')->nullable();
            $table->string('date_format')->default('m/d/Y');
            $table->enum('time_format', [12, 24])->default(24);
            $table->string('time_zone')->default('Asia/Karachi');
            $table->string('start_month', 40);
            $table->integer('transaction_edit_days')->unsigned()->default(30);
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
        Schema::dropIfExists('system_settings');
    }
}
