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
            $table->string('sku', 256)->nullable();
            $table->string('product_name', 256)->nullable();
            $table->double('cost_price', 15, 2)->nullable();
            $table->double('sell_price', 15, 2)->nullable();
            $table->double('wholesale_price', 15, 2)->nullable();
            $table->double('wholesale_quantity', 15, 2)->nullable();
            $table->string('stock_level', 256)->nullable();
            $table->integer('renter_id')->nullable();
            $table->string('brand', 256)->nullable();
            $table->string('tags', 256)->nullable();
            $table->string('description', 256)->nullable();
            $table->integer('created_by')->nullable();
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
