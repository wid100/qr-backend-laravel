<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddExpiredToSubscriptionsStatus extends Migration
{
    public function up()
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement(
            "ALTER TABLE `subscriptions` MODIFY COLUMN `status` ENUM('active', 'inactive', 'expired') NOT NULL DEFAULT 'active'"
        );
    }

    public function down()
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement(
            "ALTER TABLE `subscriptions` MODIFY COLUMN `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active'"
        );
    }
}
