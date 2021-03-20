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
            $table->id();
            $table->uuid('product_uuid');
            $table->string('name', 50);
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('unit_id');

            $table->foreign('unit_id')->on('units')->references('id');

            $table->tinyInteger('is_popular')->default(0);

            $table->decimal('price')->nullable();
            $table->tinyInteger('available')->default(0);
            $table->softDeletes();
            $table->timestamps();
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
