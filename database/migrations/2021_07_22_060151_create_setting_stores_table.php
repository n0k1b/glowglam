<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('store_tagline')->nullable();
            $table->string('store_email');
            $table->string('store_phone');
            $table->string('store_address_1')->nullable();
            $table->string('store_address_2')->nullable();
            $table->string('store_city')->nullable();
            $table->string('store_country')->nullable();
            $table->string('store_state')->nullable();
            $table->string('store_zip')->nullable();
            $table->tinyInteger('hide_store_phone')->nullable();
            $table->tinyInteger('hide_store_email')->nullable();

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
        Schema::dropIfExists('setting_stores');
    }
}
