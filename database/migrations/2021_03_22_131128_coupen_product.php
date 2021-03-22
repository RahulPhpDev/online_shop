<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CoupenProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

           Schema::create('coupen_product', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('product_id');

             $table->unsignedBigInteger('coupen_id');

            $table->foreign('product_id')->on('products')->references('id');
            $table->foreign('coupen_id')->on('coupens')->references('id');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
