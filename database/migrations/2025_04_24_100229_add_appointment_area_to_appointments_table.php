<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppointmentAreaToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_area')->nullable(); // foreign key field
            $table->foreign('appointment_area')
                ->references('id')
                ->on('schedule_areas')
                ->onDelete('cascade');  // cascade delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['appointment_area']);
            $table->dropColumn('appointment_area');
        });
    }
}
