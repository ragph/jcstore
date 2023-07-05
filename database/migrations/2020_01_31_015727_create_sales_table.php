<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_no', 256)->nullable();
            $table->string('customer_name', 250)->nullable();
            $table->double('payment', 15, 2)->nullable();
            $table->double('total_items', 15, 2)->nullable();
            $table->double('tax', 15, 2)->nullable();
            $table->double('total_payment', 15, 2)->nullable();
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
        Schema::dropIfExists('sales');
    }
}
