<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * MySQL can end up with `websites.id` not AUTO_INCREMENT (manual DDL, import,
 * or drift). Inserts then fail with: SQLSTATE[HY000]: Field 'id' doesn't have a default value.
 */
class FixWebsitesIdAutoIncrement extends Migration
{
    public function up()
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        // id must be a KEY before MySQL allows AUTO_INCREMENT (error 1075 otherwise).
        DB::statement(
            'ALTER TABLE `websites` MODIFY COLUMN `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY'
        );
    }

    public function down()
    {
        // Intentionally empty: reversing AUTO_INCREMENT can break existing rows.
    }
}
