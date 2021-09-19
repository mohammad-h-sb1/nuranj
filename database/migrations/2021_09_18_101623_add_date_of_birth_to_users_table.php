<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateOfBirthToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('date_of_birth')->after('api_token')->nullable();
            $table->string('national_code')->after('date_of_birth')->nullable();
            $table->string('national_code_img_url')->nullable()->after('national_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('date_of_birth');
            $table->dropColumn('national_code');
            $table->dropColumn('national_code_url');
        });
    }
}
