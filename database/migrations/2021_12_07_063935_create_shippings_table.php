<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->string('city')->unique();
            $table->decimal('rate');
            $table->timestamps();
        });

        Schema::create('shipping_product', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('shipping_id');
            $table->foreign('shipping_id')->references('id')->on('shippings');

            $table->BigInteger('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippings');
    }
}
