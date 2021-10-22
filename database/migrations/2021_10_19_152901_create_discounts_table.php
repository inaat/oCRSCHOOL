<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('discount_name');
            $table->integer('system_settings_id')->unsigned();
            $table->foreign('system_settings_id')->references('id')->on('system_settings')->onDelete('cascade');
            $table->integer('campus_id')->unsigned()->nullable();
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->string('discount_type')->nullable();
            $table->decimal('discount_amount', 22, 4)->default(0);
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
        Schema::dropIfExists('discounts');
    }
}
