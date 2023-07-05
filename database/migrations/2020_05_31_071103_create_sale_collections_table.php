<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('renter_id')->nullable();
            $table->double('amount', 15, 2)->nullable();
            $table->date('sales_from')->nullable();
            $table->date('sales_to')->nullable();
            $table->date('date_released')->nullable();
            $table->string('note', 256)->nullable();
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
        Schema::dropIfExists('sale_collections');
    }
}
