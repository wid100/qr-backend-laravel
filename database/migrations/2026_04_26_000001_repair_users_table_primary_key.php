<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Repairs the `users` table when the PRIMARY KEY and AUTO_INCREMENT have
 * been lost (e.g. a partial backup/restore). Without this, INSERTs fail
 * with "Field 'id' doesn't have a default value" and registration breaks.
 *
 * Idempotent: only alters when the index is missing.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $hasPrimary = collect(DB::select('SHOW INDEX FROM users'))
            ->contains(fn ($i) => $i->Key_name === 'PRIMARY');

        if ($hasPrimary) {
            return;
        }

        $maxId = (int) (DB::table('users')->max('id') ?? 0);
        $startAt = $maxId + 1;

        DB::statement('ALTER TABLE `users` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
        DB::statement("ALTER TABLE `users` AUTO_INCREMENT = {$startAt}");
    }

    public function down(): void
    {
        // No-op: removing a primary key is destructive and not desired.
    }
};
