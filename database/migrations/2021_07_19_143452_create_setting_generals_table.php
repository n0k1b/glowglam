<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_generals', function (Blueprint $table) {
            $table->id();
            $table->text('supported_countries');
            $table->string('default_country');
            $table->string('default_timezone');
            $table->string('customer_role');
            $table->integer('number_format');
            $table->tinyInteger('reviews_and_ratings')->nullable();
            $table->tinyInteger('auto_approve_reviews')->nullable();
            $table->tinyInteger('cookie_bar')->nullable();
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
        Schema::dropIfExists('setting_generals');
    }
}
