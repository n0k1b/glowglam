<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->string('brands')->nullable();
            $table->string('categories')->nullable();
            $table->string('tags')->nullable();
            $table->decimal('price')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('weight')->nullable();
            $table->string('image')->nullable();
            $table->string('option_1')->nullable();
            $table->string('option_value_1')->nullable();
            $table->string('option_2')->nullable();
            $table->string('option_value_2')->nullable();
            $table->string('option_3')->nullable();
            $table->string('option_value_3')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('tax')->nullable();
            $table->decimal('subtotal')->nullable();

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
