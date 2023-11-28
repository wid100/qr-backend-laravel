<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qrgens', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('cardname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email1')->nullable();
            $table->string('email2')->nullable();
            $table->string('phone1')->nullable();
            $table->string('slug');

            $table->string('phone2')->nullable();
            $table->string('mobile1')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('mobile3')->nullable();
            $table->string('mobile4')->nullable();
            $table->string('fax')->nullable();
            $table->string('fax2')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('webaddress1')->nullable();
            $table->string('webaddress2')->nullable();
            $table->string('companyname')->nullable();
            $table->string('jobtitle')->nullable();
            $table->string('maincolor')->nullable();
            $table->string('gradientcolor')->nullable();
            $table->string('buttoncolor')->nullable();
            $table->string('checkgradient')->nullable();
            $table->string('viewcount')->default(0);
            $table->text('summary')->nullable();
            $table->string('cardtype')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('github')->nullable();
            $table->string('image')->nullable();
            $table->string('qrcodeimage')->nullable();
            $table->string('welcome')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrgens');
    }
};
