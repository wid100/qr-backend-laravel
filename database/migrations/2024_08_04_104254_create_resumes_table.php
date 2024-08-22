<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('photo')->nullable();
            $table->string('resume_name')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('education')->nullable();
            $table->text('skill')->nullable();
            $table->text('language')->nullable();
            $table->text('interest')->nullable();
            $table->text('experience')->nullable();
            $table->text('references')->nullable();
            $table->text('social')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('profession')->nullable();
            $table->string('city')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->text('other')->nullable();
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
        Schema::dropIfExists('resumes');
    }
}
