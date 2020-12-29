<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('firstName');
            $table->string('lastName')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('ssn')->unique()->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('phone')->unique();
            $table->string('adress');
            $table->float("salary")->nullable();
            $table->double("commission")->nullable();
            $table->string('image')->default('user.png');
            $table->string('area_id')->nullable();
            $table->string('user_code')->nullable();
            $table->string('api_token');
            $table->rememberToken();
            $table->timestamps();

            // $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
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
