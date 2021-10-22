<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('system_settings_id')->unsigned();
            $table->foreign('system_settings_id')->references('id')->on('system_settings')->onDelete('cascade');
            $table->string('name');
            $table->string('account_number');
            $table->integer('account_type_id')->nullable();
            $table->text('note')->nullable();
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_closed')->default(0);
            $table->softDeletes();
            $table->timestamps();


        });

        // Schema::table('accounts', function(Blueprint $table)
        // {
        //     $table->index('system_settings_id');
        //     $table->index('account_type_id');
        //     $table->index('created_by');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
