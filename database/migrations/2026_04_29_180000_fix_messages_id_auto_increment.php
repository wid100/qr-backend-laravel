<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Same drift as `websites`: `messages.id` may lack AUTO_INCREMENT + PRIMARY KEY on some MySQL setups.
 */
class FixMessagesIdAutoIncrement extends Migration
{
    public function up()
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement(
            'ALTER TABLE `messages` MODIFY COLUMN `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY'
        );
    }

    public function down()
    {
        //
    }
}
