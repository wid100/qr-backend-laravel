<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Repairs `appointments.id` AUTO_INCREMENT when the primary key exists but the
 * column lost the AUTO_INCREMENT attribute (common after some restore tools).
 *
 * Idempotent: only alters when `id` isn't auto_increment.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('appointments')) {
            return;
        }

        $idCol = collect(DB::select("SHOW COLUMNS FROM `appointments` LIKE 'id'"))->first();
        $extra = strtolower((string) ($idCol->Extra ?? ''));

        if (str_contains($extra, 'auto_increment')) {
            return;
        }

        $maxId = (int) (DB::table('appointments')->max('id') ?? 0);
        $startAt = $maxId + 1;

        $hasPrimary = collect(DB::select('SHOW INDEX FROM appointments'))
            ->contains(fn ($i) => $i->Key_name === 'PRIMARY');

        // If PRIMARY already exists, only restore AUTO_INCREMENT.
        // If PRIMARY is missing, restore both.
        if ($hasPrimary) {
            DB::statement('ALTER TABLE `appointments` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        } else {
            DB::statement('ALTER TABLE `appointments` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
        }
        DB::statement("ALTER TABLE `appointments` AUTO_INCREMENT = {$startAt}");
    }

    public function down(): void
    {
        // No-op.
    }
};

