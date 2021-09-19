<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('user_id');
            $table->string('logo')->nullable();
            $table->string('shaba_number')->nullable();
            $table->string('Favicon')->nullable();
            $table->string('phone2')->nullable();
            $table->string('instagram')->nullable();
            $table->string('telegram')->nullable();
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
        Schema::dropIfExists('shop_metas');
    }
}
