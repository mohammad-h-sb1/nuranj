<?php

use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('company');
            $table->boolean('website')->default(0);
            $table->boolean('application')->default(0);
            $table->boolean('startup')->default(0);
            $table->boolean('work_experience')->default(0);
            $table->boolean('coding')->default(0);
            $table->boolean('trade_relations')->default(0);
            $table->text('description');
            $table->enum('level',Project::LEVELS)->default(Project::LEVEL_ANALYSIS);
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('projects');
    }
}
