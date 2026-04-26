<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Repairs missing PRIMARY KEY / AUTO_INCREMENT on critical billing tables.
 * We already saw this corruption on `users` and `resumes`; it also breaks
 * Stripe transaction saving when `payments.id` is not auto-increment.
 */
return new class extends Migration
{
    private function ensurePrimaryAutoIncrement(string $table): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        $hasPrimary = collect(DB::select("SHOW INDEX FROM {$table}"))
            ->contains(fn ($i) => $i->Key_name === 'PRIMARY');

        if ($hasPrimary) {
            return;
        }

        $maxId = (int) (DB::table($table)->max('id') ?? 0);
        $startAt = $maxId + 1;

        DB::statement("ALTER TABLE `{$table}` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY");
        DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = {$startAt}");
    }

    public function up(): void
    {
        $this->ensurePrimaryAutoIncrement('payments');
        $this->ensurePrimaryAutoIncrement('orders');
        $this->ensurePrimaryAutoIncrement('subscriptions');
    }

    public function down(): void
    {
        // No-op (destructive to remove PKs).
    }
};

