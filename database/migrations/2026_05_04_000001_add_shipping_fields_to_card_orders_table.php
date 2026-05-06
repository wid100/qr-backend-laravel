<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingFieldsToCardOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('card_orders', function (Blueprint $table) {
            if (! Schema::hasColumn('card_orders', 'name')) {
                $table->string('name')->nullable()->after('smart_card_id');
            }
            if (! Schema::hasColumn('card_orders', 'email')) {
                $table->string('email')->nullable()->after('name');
            }
            if (! Schema::hasColumn('card_orders', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (! Schema::hasColumn('card_orders', 'country')) {
                $table->string('country')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('card_orders', 'town')) {
                $table->string('town')->nullable()->after('country');
            }
            if (! Schema::hasColumn('card_orders', 'city')) {
                $table->string('city')->nullable()->after('town');
            }
            if (! Schema::hasColumn('card_orders', 'address')) {
                $table->string('address')->nullable()->after('city');
            }
            if (! Schema::hasColumn('card_orders', 'zip')) {
                $table->string('zip')->nullable()->after('address');
            }
            if (! Schema::hasColumn('card_orders', 'currency')) {
                $table->string('currency', 10)->nullable()->after('zip');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_orders', function (Blueprint $table) {
            $columns = ['name', 'email', 'phone', 'country', 'town', 'city', 'address', 'zip', 'currency'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('card_orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
