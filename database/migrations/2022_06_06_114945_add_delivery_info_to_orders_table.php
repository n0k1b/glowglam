<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryInfoToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //php artisan make:migration add_delivery_info_to_orders_table --table=orders

        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_date')->nullable()->after('order_status');
            $table->string('delivery_time')->nullable()->after('delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_date');
            $table->dropColumn('delivery_time');
        });
    }
}
