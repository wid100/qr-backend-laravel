<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmartCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smart_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->string('discount_price');
            $table->string('font_image');
            $table->string('back_image');
            $table->text('description');
            $table->integer('status')->default(0)->comment('0: Active, 1: Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smart_cards');
    }
}
