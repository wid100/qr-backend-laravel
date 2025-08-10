<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMediumToQrgensTable extends Migration
{
    public function up(): void
    {
        Schema::table('qrgens', function (Blueprint $table) {
            $table->string('medium')->nullable()->after('google_scholar');
        });
    }

    public function down(): void
    {
        Schema::table('qrgens', function (Blueprint $table) {
            $table->dropColumn('medium');
        });
    }
}
