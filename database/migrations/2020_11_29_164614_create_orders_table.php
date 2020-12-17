<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('status')->comment('0=> wating when end shoping 1=> finish this order');
            // $table->dateTime('fire_date'); created_at = fire_date
            $table->dateTime('end_shoping_date')->comment('from delivery');
            $table->dateTime('arrival_date')->comment('from delivery');
            $table->float('delivery_price');
            $table->text('feedback')->comment('from client');
            $table->dateTime('feedback_date')->comment('from client');
            $table->bigInteger('delivery_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('area_id')->unsigned();
            $table->timestamps();

            $table->foreign('delivery_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
