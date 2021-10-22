<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('system_settings_id');
            $table->string('file_name');
            $table->text('description')->nullable();
            $table->integer('uploaded_by')->nullable();
            $table->morphs('model');
            $table->string('model_media_type')->nullable();
            $table->index('system_settings_id');
            $table->index('uploaded_by');

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
        Schema::dropIfExists('media');
    }
}
