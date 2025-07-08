<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('qrgen_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('smart_card_id')->index();

            // Order details
            $table->string('order_number')->unique();
            $table->dateTime('order_date')->default(now());
            $table->string('shipping_address')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('tracking_number')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();

            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('total_price', 10, 2)->default(0.00);
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_orders');
    }
}
