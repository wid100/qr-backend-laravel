<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleHealthCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('person_name');
            $table->string('person_photo')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_group')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->enum('card_type', ['pregnant', 'child', 'adult', 'senior']);
            $table->date('expected_delivery_date')->nullable();
            $table->text('emergency_contact')->nullable();
            $table->text('allergies')->nullable();
            $table->string('slug')->unique();
            $table->string('username')->nullable(); // For public URL
            $table->string('qr_code_hash')->unique()->nullable();
            $table->enum('access_type', ['private', 'protected', 'public'])->default('private');
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('slug');
            $table->index('username');
            $table->index('qr_code_hash');
            $table->index('access_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_cards');
    }
}
