<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Repairs the `appointments` table when the PRIMARY KEY / AUTO_INCREMENT has been
 * lost (e.g. a partial backup/restore). Without this, inserts fail with:
 * "Field 'id' doesn't have a default value".
 *
 * Idempotent: only alters when PRIMARY index is missing.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('appointments')) {
            return;
        }

        $hasPrimary = collect(DB::select('SHOW INDEX FROM appointments'))
            ->contains(fn ($i) => $i->Key_name === 'PRIMARY');

        if ($hasPrimary) {
            return;
        }

        $maxId = (int) (DB::table('appointments')->max('id') ?? 0);
        $startAt = $maxId + 1;

        DB::statement('ALTER TABLE `appointments` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
        DB::statement("ALTER TABLE `appointments` AUTO_INCREMENT = {$startAt}");
    }

    public function down(): void
    {
        // No-op (destructive to remove primary key).
    }
};

