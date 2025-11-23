<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthCardMedicalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_card_medical_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_card_id')->constrained('health_cards')->onDelete('cascade');
            $table->date('visit_date'); // Kon din doctor dakhaice
            $table->string('doctor_name'); // Kon doctor dakhaice
            $table->string('hospital_name')->nullable(); // Kon hospital
            $table->text('medicines')->nullable(); // Ki medicin diyace (JSON or text)
            $table->text('diet_rules')->nullable(); // Khawyar niom
            $table->text('recommendations')->nullable(); // Kono recomendation ace ki na
            $table->json('test_data')->nullable(); // Test data (test name, results, etc.)
            $table->string('prescription_image')->nullable(); // Prescription image path
            $table->string('test_report_image')->nullable(); // Test report image path
            $table->text('notes')->nullable(); // Additional notes
            $table->timestamps();

            // Indexes
            $table->index('health_card_id');
            $table->index('visit_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_card_medical_reports');
    }
}
