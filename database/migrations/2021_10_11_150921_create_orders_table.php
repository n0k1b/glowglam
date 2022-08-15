<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->string('billing_country');
            $table->string('billing_address_1');
            $table->string('billing_address_2')->nullable();
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_zip_code');
            $table->string('shipping_method')->nullable();
            $table->string('shipping_cost')->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('currency_base_total')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('order_status')->nullable();
            // $table->string('delivery_date')->nullable();
            // $table->string('delivery_time')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('date')->nullable();
            $table->integer('tax_id')->nullable();
            $table->decimal('tax')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
