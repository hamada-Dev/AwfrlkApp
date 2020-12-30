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
            $table->tinyInteger('status')->default(0)->comment('0=> wating when end shoping 1=> finish this order');
            // $table->dateTime('fire_date'); created_at = fire_date
            $table->dateTime('end_shoping_date')->nullable()->comment('from delivery');
            $table->dateTime('arrival_date')->nullable()->comment('from delivery');
            $table->float('delivery_price');
            $table->text('feedback')->nullable()->comment('from client');
            $table->dateTime('feedback_date')->nullable()->comment('from client');
            $table->bigInteger('delivery_id')->nullable()->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('area_id')->unsigned();
            $table->string('adress')->nullable();
            $table->bigInteger('area_id_from')->nullable()->unsigned();
            $table->string('adress_from')->nullable();
            
            $table->timestamps();
            $table->bigInteger('deleted_by')->nullable()->unsigned()->comment('who deleted if nullable this mean this item is visable');
            $table->dateTime('delete_date')->nullable()->comment(' date when this item is deleted');
           
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('delivery_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('area_id_from')->references('id')->on('areas')->onDelete('cascade');
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
