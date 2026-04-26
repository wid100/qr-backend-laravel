<?php

// One-off helper to repair the `migrations` table id/auto_increment locally.
// Safe to run multiple times.

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

if (!Schema::hasTable('migrations')) {
    fwrite(STDERR, "ERROR: migrations table not found.\n");
    exit(1);
}

$hasPrimary = collect(DB::select('SHOW INDEX FROM migrations'))
    ->contains(fn ($i) => $i->Key_name === 'PRIMARY');

$primaryCols = collect(DB::select('SHOW INDEX FROM migrations'))
    ->filter(fn ($i) => $i->Key_name === 'PRIMARY')
    ->sortBy('Seq_in_index')
    ->pluck('Column_name')
    ->values()
    ->all();

$idCol = collect(DB::select("SHOW COLUMNS FROM `migrations` LIKE 'id'"))->first();
$extra = strtolower((string) ($idCol->Extra ?? ''));
$hasAutoIncrement = str_contains($extra, 'auto_increment');

// Ensure PRIMARY KEY is on `id` (required for AUTO_INCREMENT).
try {
    if ($hasPrimary && $primaryCols !== ['id']) {
        DB::statement('ALTER TABLE `migrations` DROP PRIMARY KEY');
        $hasPrimary = false;
        $primaryCols = [];
    }
    if (!$hasPrimary) {
        DB::statement('ALTER TABLE `migrations` ADD PRIMARY KEY (`id`)');
        $hasPrimary = true;
        $primaryCols = ['id'];
    }
} catch (Throwable $e) {
    fwrite(STDERR, "WARN: PRIMARY KEY normalize failed: {$e->getMessage()}\n");
}

try {
    if (!$hasAutoIncrement) {
        DB::statement('ALTER TABLE `migrations` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        $hasAutoIncrement = true;
    }
} catch (Throwable $e) {
    fwrite(STDERR, "WARN: AUTO_INCREMENT fix failed: {$e->getMessage()}\n");
}

echo "migrations table repaired (primary=" . ($hasPrimary ? 'yes' : 'no') . ", primary_cols=" . json_encode($primaryCols) . ", auto_increment=" . ($hasAutoIncrement ? 'yes' : 'no') . ")\n";

