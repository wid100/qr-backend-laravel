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
            $table->foreignId('template_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('slug');
            $table->string('photo')->nullable();
            $table->string('resume_name')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->json('education')->nullable();
            $table->json('skill')->nullable();
            $table->json('language')->nullable();
            $table->json('interest')->nullable();
            $table->json('experience')->nullable();
            $table->json('references')->nullable();
            $table->text('social')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('profession')->nullable();
            $table->string('city')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->json('other')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('text_color')->nullable();
            $table->integer('status')->default(0)->comment('0 = active, 1 = inactive');
            $table->integer('viewcount')->default(0);
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
