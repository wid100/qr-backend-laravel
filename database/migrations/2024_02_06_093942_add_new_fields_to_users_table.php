<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_id')->after('id')->default(2)->nullable();
            $table->string('gender')->after('email')->nullable();
            $table->string('country')->after('gender')->nullable();
            $table->string('city')->after('country')->nullable();
            $table->string('address')->after('city')->nullable();
            $table->string('country_code')->after('address')->nullable();
            $table->string('phone')->after('country_code')->nullable();
            $table->string('status')->after('phone')->nullable();
            $table->string('image')->after('status')->nullable();
            $table->string('verify_code')->after('email_verified_at')->nullable();
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
            //
        });
    }
}
