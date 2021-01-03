<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersalaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float("salary")->nullable();
            $table->double("commission")->nullable();
            $table->BigInteger("user_id")->unsigned();
            $table->dateTime('moneyDay')->nullable()->comment('day for take salary');

            $table->bigInteger("added_by")->unsigned()->comment('who added');
            $table->bigInteger('deleted_by')->nullable()->unsigned();
            $table->dateTime("delete_date")->nullable();
           
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usersalaries');
    }
}
