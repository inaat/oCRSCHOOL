<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampusIdAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campuses', function (Blueprint $table) {
            $table->integer('created_by')->unsigned()->after('system_settings_id');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('campus_id')->unsigned()->nullable()->after('system_settings_id');
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->boolean('default_campus_account')->default(0)->after('campus_id');


        });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
