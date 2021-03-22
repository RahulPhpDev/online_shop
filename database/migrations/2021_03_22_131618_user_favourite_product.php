<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserFavouriteProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('user_favourite_product', function (Blueprint $table) {
               $table->id();
                $table->unsignedBigInteger('product_id');

                $table->unsignedBigInteger('user_id');

                $table->foreign('product_id')->on('products')->references('id');
                $table->foreign('user_id')->on('users')->references('id');
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
