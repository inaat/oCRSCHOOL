<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSystemSettingIdRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->integer('system_settings_id')->unsigned()->after('guard_name');
            $table->foreign('system_settings_id')->references('id')->on('system_settings')->onDelete('cascade');
            $table->boolean('is_default')->default(0)->after('system_settings_id');

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
