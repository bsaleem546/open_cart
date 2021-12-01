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

            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->string('name')->unique();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();

            $table->integer('quantity')->default(0);
            $table->decimal('price')->default(0);
            $table->integer('in_stock')->nullable();

            $table->boolean('has_attributes')->default(false);

            $table->timestamps();
        });

        //product images
        Schema::create('image_product', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('paths');
            $table->boolean('is_main')->default(false);
        });

        //product attributes
        Schema::create('attribute_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->unsignedBigInteger('attribute_id');
            $table->foreign('attribute_id')->references('id')->on('attributes');

            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')->references('id')->on('options');

            $table->integer('quantity')->nullable();
            $table->decimal('price')->nullable();
            $table->boolean('in_stock')->nullable();
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
