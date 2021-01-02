<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("user_id")->unsigned();
            $table->float("getmoney");
            $table->float("givemoney")->nullable();
            $table->bigInteger("added_by")->unsigned()->comment('who added');
            $table->bigInteger('deleted_by')->nullable()->unsigned();
            $table->dateTime("delete_date")->nullable();
            $table->tinyInteger('flag')->nullable()->default(0)->comment('0 is  show 1 hide');

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
        Schema::dropIfExists('advances');
    }
}
