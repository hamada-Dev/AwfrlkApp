<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->float('price');
            $table->integer('trips_count');
            $table->integer('offer_days')->comment('number of offer day');
            $table->tinyInteger('avilable')->default(1)->comment('0=> notAvilable 1=> avilable');
            $table->bigInteger('area_id')->unsigned();
            $table->bigInteger('deleted_by')->nullable()->unsigned()->comment('who deleted if nullable this mean this item is visable');
            $table->dateTime('delete_date')->nullable()->comment(' date when this item is deleted');
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
