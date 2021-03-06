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
            $table->string('name');
            $table->string('lastName')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('ssn')->unique()->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('adress')->nullable();
            $table->string('image')->default('user.png');
            $table->string('area_id')->nullable();
            $table->string('user_code')->nullable();
            $table->string('api_token');
            $table->bigInteger('deleted_by')->nullable()->unsigned()->comment('who deleted if nullable this mean this item is visable');
            $table->dateTime('delete_date')->nullable()->comment(' date when this item is deleted');
            $table->integer("added_by")->nullable();
            $table->rememberToken();
            $table->timestamps();

            /// edit for chatfy
            $table->integer('active_status')->nullable();
            $table->integer('dark_mode')->nullable();
            $table->string('messenger_color')->nullable();
            $table->string('avatar')->nullable();
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
