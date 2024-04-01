<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToQrgensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qrgens', function (Blueprint $table) {
            $table->string('behance')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('spotify')->nullable();
            $table->string('tumblr')->nullable();
            $table->string('telegram')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('reddit')->nullable();
            $table->string('google')->nullable();
            $table->string('apple')->nullable();
            $table->string('figma')->nullable();
            $table->string('discord')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('skype')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qrgens', function (Blueprint $table) {
            //
        });
    }
}
