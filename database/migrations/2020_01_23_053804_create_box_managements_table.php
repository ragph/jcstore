<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('renter_id')->nullable();
            $table->integer('branch')->nullable();
            $table->string('box_id')->nullable();
            $table->date('date_of_contract')->nullable();
            $table->date('end_of_contract')->nullable();
            $table->date('due_date')->nullable();
            $table->string('description', 512)->nullable();
            $table->double('rental_cost', 15, 2)->nullable();
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
        Schema::dropIfExists('box_managements');
    }
}