<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrVisitorContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_visitor_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qrgen_id');
            $table->string('visitor_name', 255);
            $table->string('visitor_phone', 64);
            $table->text('note')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index('qrgen_id');
            $table->foreign('qrgen_id')->references('id')->on('qrgens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qr_visitor_contacts');
    }
}
