<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->string('prescription_number')->unique();
            $table->date('prescription_date');
            $table->string('doctor_name');
            $table->string('doctor_license')->nullable();
            $table->string('clinic_name')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('symptoms')->nullable();
            $table->text('notes')->nullable();
            $table->json('medicines'); // Array of medicines with details
            $table->json('dosage_instructions'); // Dosage instructions
            $table->string('original_image_path'); // Original prescription image
            $table->string('processed_image_path')->nullable(); // Processed/cleaned image
            $table->json('ocr_data')->nullable(); // Raw OCR extracted data
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
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
        Schema::dropIfExists('prescriptions');
    }
}
