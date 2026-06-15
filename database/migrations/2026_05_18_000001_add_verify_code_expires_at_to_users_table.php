<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'verify_code_expires_at')) {
                $table->timestamp('verify_code_expires_at')->nullable()->after('verify_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'verify_code_expires_at')) {
                $table->dropColumn('verify_code_expires_at');
            }
        });
    }
};
