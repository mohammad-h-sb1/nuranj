<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shop_id');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->boolean('request_automatic_transfer_to_cart')->default(0)->nullable();
            $table->boolean('quick_product_purchase')->default(0)->nullable();
            $table->boolean('fixed_shopping_cart')->default(0)->nullable();
            $table->boolean('product_is_not_sold')->default(0)->nullable();
            $table->timestamps();

            $table->unique(['user_id','shop_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_information');
    }
}
