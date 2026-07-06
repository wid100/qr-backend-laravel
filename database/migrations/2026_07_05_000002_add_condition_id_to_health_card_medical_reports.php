<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionIdToHealthCardMedicalReports extends Migration
{
    public function up()
    {
        Schema::table('health_card_medical_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('health_card_medical_reports', 'condition_id')) {
                $table->unsignedBigInteger('condition_id')->nullable()->after('health_card_id');
                $table->index('condition_id');
            }
        });
    }

    public function down()
    {
        Schema::table('health_card_medical_reports', function (Blueprint $table) {
            if (Schema::hasColumn('health_card_medical_reports', 'condition_id')) {
                $table->dropIndex(['condition_id']);
                $table->dropColumn('condition_id');
            }
        });
    }
}
