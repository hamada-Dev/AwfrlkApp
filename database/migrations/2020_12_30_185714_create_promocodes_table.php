<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("user_id")->nullable()->unsigned();
            $table->string("name")->comment("name of promocode");
            $table->string('serial')->unique()->nullable();
            $table->tinyInteger("confirm")->comment(" 1 is valide 0 is not valide");
            $table->integer("discount")->unsigned()->comment("discount for percent");
            $table->dateTime("end_date")->nullable()->comment("the end date for promocodes");
            $table->bigInteger("added_by")->unsigned()->comment('who added');
            $table->bigInteger('deleted_by')->nullable()->unsigned()->comment('who deleted if nullable this mean this item is visable');
            $table->dateTime("delete_date")->nullable();

            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocodes');
    }
}
