<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->text('house_no');
            $table->text('street');
            $table->string('state', 25);
            $table->string('district', 25);
            $table->integer('pin_code')->nullable();
            $table->text('landmark')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0->resident,1->office');

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
        Schema::dropIfExists('addresses');
    }
}
