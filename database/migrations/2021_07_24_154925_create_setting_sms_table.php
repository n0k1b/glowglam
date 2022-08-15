<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_sms', function (Blueprint $table) {
            $table->id();
            $table->string('sms_from');
            $table->string('sms_service')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->string('account_sid')->nullable();
            $table->string('auth_token')->nullable();
            $table->tinyInteger('welcome_sms')->nullable();
            $table->tinyInteger('new_order_sms_to_admin')->nullable();
            $table->tinyInteger('new_order_sms_to_customer')->nullable();
            $table->string('sms_order_status')->nullable();
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
        Schema::dropIfExists('setting_sms');
    }
}
