<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryMotocyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_motocycles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_license')->unique();
            $table->string('moto_license')->unique();
            $table->string('moto_number')->unique();
            $table->dateTime('license_renew_date');
            $table->dateTime('license_expire_date');
            $table->string('type');
            $table->string('color');
            $table->bigInteger('user_id')->unsigned();
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
        Schema::dropIfExists('delivery_motocycles');
    }
}
