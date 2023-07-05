<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->tinyInteger('branch')->nullable();
            $table->tinyInteger('renters_profile')->nullable();
            $table->tinyInteger('cube_management')->nullable();
            $table->tinyInteger('product_management')->nullable();
            $table->tinyInteger('inventory')->nullable();
            $table->tinyInteger('pos')->nullable();
            $table->tinyInteger('users')->nullable();
            $table->tinyInteger('rent_management')->nullable();
            $table->tinyInteger('report')->nullable();
            $table->tinyInteger('settings')->nullable();
            $table->tinyInteger('sale_collections')->nullable();
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
        Schema::dropIfExists('user_roles');
    }
}
