<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstagramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instagrams', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('instagram_name');
            $table->string('instagram_username');
            $table->unsignedBigInteger('insta_category')->nullable();
            $table->foreign('insta_category')->references('id')->on('insta_categories')->onDelete('cascade');
            $table->string('frame_color')->nullable();
            $table->string('code_color')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('instagrams');
    }
}
