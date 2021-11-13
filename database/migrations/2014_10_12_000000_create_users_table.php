<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('surname');
            $table->enum('user_type',['admin','manager','teacher','guardian','staff','student'])->nullable();
            $table->unsignedInteger('hook_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();





            // $table->increments('id');
            // $table->string('surname');
            // $table->string('first_name');
            // $table->string('last_name')->nullable();
            // $table->string('email')->nullable();
            // $table->string('password');
            // $table->char('language', 7)->default('en');
            // $table->timestamp('email_verified_at')->nullable();            
            // $table->rememberToken();
            // $table->timestamps();
            // $table->integer('business_id')->unsigned()->nullable()->after('remember_token');
            // $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            // $table->enum('status', ['active', 'inactive', 'terminated'])->default('active')->after('business_id');
            // $table->boolean('allow_login')->default(1)->after('business_id');
            // $table->string('user_type')->default('user')->index()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
