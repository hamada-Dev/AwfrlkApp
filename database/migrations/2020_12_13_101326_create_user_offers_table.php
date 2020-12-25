<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('offer_id')->unsigned();
            $table->integer('decrement_trip')->comment('this number of trip offer that dec every order');
            $table->double('price')->comment('the price of offer becouse if user update offer this userOffer not have problem');
            $table->timestamps();
            $table->dateTime('end_date')->nullable()->comment(' = this.created_at + offers.offer_days');
            $table->bigInteger('added_by')->unsigned()->comment('who added');
            $table->bigInteger('deleted_by')->nullable()->unsigned()->comment('who deleted if nullable this mean this item is visable');
            $table->dateTime('delete_date')->nullable()->comment(' date when this item is deleted');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_offers');
    }
}
