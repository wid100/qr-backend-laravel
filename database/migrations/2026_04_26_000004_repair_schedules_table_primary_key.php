<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Repairs the `schedules` table when the PRIMARY KEY / AUTO_INCREMENT has been
 * lost (e.g. a partial backup/restore). Without this, inserts fail with:
 * "Field 'id' doesn't have a default value".
 *
 * Idempotent: only alters when PRIMARY index is missing.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('schedules')) {
            return;
        }

        $hasPrimary = collect(DB::select('SHOW INDEX FROM schedules'))
            ->contains(fn ($i) => $i->Key_name === 'PRIMARY');

        if ($hasPrimary) {
            return;
        }

        $maxId = (int) (DB::table('schedules')->max('id') ?? 0);
        $startAt = $maxId + 1;

        DB::statement('ALTER TABLE `schedules` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
        DB::statement("ALTER TABLE `schedules` AUTO_INCREMENT = {$startAt}");
    }

    public function down(): void
    {
        // No-op (destructive to remove primary key).
    }
};

