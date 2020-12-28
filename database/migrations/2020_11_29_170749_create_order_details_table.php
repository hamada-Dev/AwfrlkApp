<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('amount')->nullable()->comment('this is for pharmacy order or from home to home');
            $table->float('price')->nullable()->comment('this is for pharmacy order or from home to home');
            $table->string('image')->nullable()->comment('this is for pharmacy order');
            $table->bigInteger('product_id')->unsigned()->nullable()->comment('this is for pharmacy order or from home to home');
            $table->string('product_home')->nullable()->comment('this is for home order');
            $table->bigInteger('order_id')->unsigned();
            
            $table->timestamps();
            $table->bigInteger('deleted_by')->nullable()->unsigned()->comment('who deleted if nullable this mean this item is visable');
            $table->dateTime('delete_date')->nullable()->comment(' date when this item is deleted');
           
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
