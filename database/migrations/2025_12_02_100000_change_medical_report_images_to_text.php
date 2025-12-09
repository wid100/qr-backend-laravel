<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeMedicalReportImagesToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use raw SQL to change column types without Doctrine DBAL
        DB::statement('ALTER TABLE health_card_medical_reports MODIFY prescription_image TEXT NULL');
        DB::statement('ALTER TABLE health_card_medical_reports MODIFY test_report_image TEXT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert back to VARCHAR(255) - adjust length as needed
        DB::statement('ALTER TABLE health_card_medical_reports MODIFY prescription_image VARCHAR(255) NULL');
        DB::statement('ALTER TABLE health_card_medical_reports MODIFY test_report_image VARCHAR(255) NULL');
    }
}

