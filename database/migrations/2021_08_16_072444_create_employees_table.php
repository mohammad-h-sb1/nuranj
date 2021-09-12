<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type',Employee::TYPE);
            $table->string('family');
            $table->enum('gender',\App\Models\User::GENDER);
            $table->boolean('marital_status');
            $table->string('age');
            $table->string('military_service_status');
            $table->string('address');
            $table->text('introduction_to')->nullable();
            $table->text('resume')->nullable();
            $table->text('educational_background')->nullable();//سوابق تحصیلی
            $table->text('language')->nullable();
            $table->text('education_courses')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
