<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Resolves: SQLSTATE[HY000]: General error: 1364 Field 'id' doesn't have a default value
 * when `id` exists but is NOT NULL without AUTO_INCREMENT (and often without PRIMARY KEY).
 */
class FixCardOrdersIdAutoincrement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('card_orders')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver !== 'mysql' && $driver !== 'mariadb') {
            return;
        }

        $database = DB::getDatabaseName();

        $col = DB::selectOne(
            'SELECT EXTRA FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?',
            [$database, 'card_orders', 'id']
        );

        if ($col && stripos((string) ($col->EXTRA ?? ''), 'auto_increment') !== false) {
            return;
        }

        $primaryKeys = DB::select(
            'SHOW KEYS FROM `card_orders` WHERE Key_name = ?',
            ['PRIMARY']
        );

        if (empty($primaryKeys)) {
            DB::statement('ALTER TABLE `card_orders` ADD PRIMARY KEY (`id`)');
        }

        try {
            DB::statement(
                'ALTER TABLE `card_orders` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT'
            );
        } catch (\Throwable $e) {
            // e.g. 1075 — `id` still not a key; define PK + AI in one step.
            DB::statement(
                'ALTER TABLE `card_orders` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY'
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Do not strip AUTO_INCREMENT on rollback.
    }
}
