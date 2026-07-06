<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthCardConditionsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('health_card_conditions')) {
            Schema::create('health_card_conditions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('health_card_id');
                $table->string('name', 191);
                $table->text('description')->nullable();
                $table->boolean('is_emergency_enabled')->default(false);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();

                $table->index('health_card_id');
                $table->index(['health_card_id', 'is_emergency_enabled']);
            });
        } else {
            Schema::table('health_card_conditions', function (Blueprint $table) {
                if (!Schema::hasColumn('health_card_conditions', 'health_card_id')) {
                    $table->unsignedBigInteger('health_card_id')->after('id');
                }
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('health_card_conditions');
    }
}
