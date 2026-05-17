<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialLinksAndWechatToQrgensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qrgens', function (Blueprint $table) {
            if (! Schema::hasColumn('qrgens', 'social_links')) {
                $table->json('social_links')->nullable()->after('medium');
            }
            if (! Schema::hasColumn('qrgens', 'wechat')) {
                $table->string('wechat')->nullable()->after('medium');
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
        Schema::table('qrgens', function (Blueprint $table) {
            if (Schema::hasColumn('qrgens', 'social_links')) {
                $table->dropColumn('social_links');
            }
            if (Schema::hasColumn('qrgens', 'wechat')) {
                $table->dropColumn('wechat');
            }
        });
    }
}
