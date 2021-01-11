<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('unit',['kilo', 'number', 'liter']);
            $table->float('price')->nullable();
            $table->string('image')->default('default.png');
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('parent_id')->default(0);
            $table->bigInteger('added_by')->unsigned()->comment('who added');
            $table->timestamps();
            
            $table->bigInteger('deleted_by')->nullable()->unsigned()->comment('who deleted if nullable this mean this item is visable');
            $table->dateTime('delete_date')->nullable()->comment(' date when this item is deleted');


            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
