<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('voucher_name', 256)->nullable();
            $table->string('type', 256)->nullable();
            $table->string('price_type', 256)->nullable();
            $table->string('percentage', 256)->nullable();
            $table->double('fix_price', 15, 2)->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('voucher_coupons');
    }
}
