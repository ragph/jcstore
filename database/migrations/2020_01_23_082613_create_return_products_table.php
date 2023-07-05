<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('location_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('quantity', 256)->nullable();
            $table->date('date')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('note', 256)->nullable();
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
        Schema::dropIfExists('return_products');
    }
}
