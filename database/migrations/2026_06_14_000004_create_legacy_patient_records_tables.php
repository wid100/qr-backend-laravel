<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('patients')) {
            Schema::create('patients', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
                $table->string('patient_id')->unique();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->date('date_of_birth')->nullable();
                $table->string('gender', 20)->nullable();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('prescriptions')) {
            Schema::create('prescriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->string('prescription_number')->unique();
                $table->date('prescription_date');
                $table->string('doctor_name')->nullable();
                $table->string('clinic_name')->nullable();
                $table->text('notes')->nullable();
                $table->json('medicines')->nullable();
                $table->json('dosage_instructions')->nullable();
                $table->string('original_image_path');
                $table->string('processed_image_path')->nullable();
                $table->json('ocr_data')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();

                $table->index('patient_id');
                $table->index('prescription_date');
            });
        }

        if (! Schema::hasTable('medical_reports')) {
            Schema::create('medical_reports', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->string('report_number')->unique();
                $table->string('report_type');
                $table->date('test_date');
                $table->string('lab_name')->nullable();
                $table->string('doctor_name')->nullable();
                $table->text('test_notes')->nullable();
                $table->json('test_results')->nullable();
                $table->json('normal_ranges')->nullable();
                $table->string('original_image_path');
                $table->string('processed_image_path')->nullable();
                $table->json('ocr_data')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();

                $table->index('patient_id');
                $table->index('test_date');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_reports');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('patients');
    }
};
