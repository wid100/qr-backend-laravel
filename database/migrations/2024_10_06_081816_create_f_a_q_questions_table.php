<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFAQQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_a_q_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('f_a_q_section_id')->constrained('f_a_q_sections')->onDelete('cascade');
            $table->string('question');
            $table->text('answer');
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
        Schema::dropIfExists('f_a_q_questions');
    }
}
