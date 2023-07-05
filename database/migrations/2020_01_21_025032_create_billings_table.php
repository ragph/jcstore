<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('box_id')->nullable();
            $table->string('cheque_number', 256)->nullable();
            $table->string('bank', 256)->nullable();
            $table->date('month_covered')->nullable();
            $table->double('cash', 15, 2)->nullable();
            $table->boolean('is_cheque')->nullable();
            $table->double('amount', 15, 2)->nullable();
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
        Schema::dropIfExists('billings');
    }
}