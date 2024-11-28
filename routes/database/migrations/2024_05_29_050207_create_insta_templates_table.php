<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstaTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insta_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('insta_category');
            $table->text('template');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('insta_category')->references('id')->on('insta_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insta_templates');
    }
}
