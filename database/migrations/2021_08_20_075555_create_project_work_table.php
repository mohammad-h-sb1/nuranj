<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_work', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_team_id');
            $table->unsignedSmallInteger('project_id');
            $table->timestamps();

            $table->foreign('work_team_id')
                ->references('id')
                ->on('work_teams')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_work');
    }
}
