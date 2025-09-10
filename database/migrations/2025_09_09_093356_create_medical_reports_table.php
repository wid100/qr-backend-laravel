<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->string('report_number')->unique();
            $table->string('report_type'); // blood_test, xray, mri, etc.
            $table->date('test_date');
            $table->string('lab_name')->nullable();
            $table->string('doctor_name')->nullable();
            $table->text('test_notes')->nullable();
            $table->json('test_results'); // Structured test results
            $table->json('normal_ranges'); // Normal ranges for comparison
            $table->string('original_image_path'); // Original report image
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
        Schema::dropIfExists('medical_reports');
    }
}
