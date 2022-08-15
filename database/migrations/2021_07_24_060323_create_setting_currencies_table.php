<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_currencies', function (Blueprint $table) {
            $table->id();
            $table->text('supported_currency');
            $table->string('default_currency');
            $table->string('currency_format');
            $table->string('exchange_rate_service')->nullable();
            $table->string('fixer_access_key')->nullable();
            $table->string('forge_api_key')->nullable();
            $table->string('currency_data_feed_key')->nullable();
            $table->tinyInteger('auto_refresh')->nullable();
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
        Schema::dropIfExists('setting_currencies');
    }
}
