<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname', 256)->nullable();
            $table->string('address', 512)->nullable();
            $table->string('contact_number', 256)->nullable();
            $table->string('email', 256)->nullable();
            // $table->integer('box_id')->nullable();
            // $table->date('due_date')->nullable();
            $table->date('date_registered')->nullable();
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
        Schema::dropIfExists('renters');
    }
}