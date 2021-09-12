<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPageIdToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->unsignedBigInteger('page_id')->nullable()->after('pro_id');
            $table->unsignedBigInteger('ticket_id')->nullable()->after('page_id');

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
//            $table->foreign('ticket_id')
//                ->references('id')
//                ->on('tickets')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('page_id');
        });
    }
}
