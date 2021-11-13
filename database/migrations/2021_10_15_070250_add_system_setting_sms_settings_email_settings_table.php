<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSystemSettingSmsSettingsEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->text('email_settings')->nullable()->after('transaction_edit_days');
            $table->text('sms_settings')->nullable()->after('email_settings');
            $table->text('ref_no_prefixes')->nullable()->after('sms_settings');
            $table->text('common_settings')->nullable()->after('ref_no_prefixes');
            $table->char('theme_color', 20)->nullable()->after('ref_no_prefixes');
            $table->boolean('enable_tooltip')->default(1)->after('ref_no_prefixes');
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
