<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_account_type_id')->nullable();
            $table->integer('system_settings_id')->unsigned();
            $table->foreign('system_settings_id')->references('id')->on('system_settings')->onDelete('cascade');
            $table->timestamps();
            $table->index('parent_account_type_id');
            $table->index('system_settings_id');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_types');
    }
}
