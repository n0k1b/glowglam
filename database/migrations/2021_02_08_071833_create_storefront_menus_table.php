<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorefrontMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storefront_menus', function (Blueprint $table) {
            $table->id();
            $table->string('navbar_text')->nullable();
            $table->unsignedBigInteger('primary_menu_id')->nullable();
            $table->unsignedBigInteger('category_menu_id')->nullable();
            $table->string('footer_menu_title_one')->nullable();
            $table->unsignedBigInteger('footer_menu_one_id')->nullable();
            $table->string('footer_menu_title_two')->nullable();
            $table->unsignedBigInteger('footer_menu_two_id')->nullable();
            $table->timestamps();

            $table->foreign('primary_menu_id')->references('id')->on('menus');
            $table->foreign('category_menu_id')->references('id')->on('menus');
            $table->foreign('footer_menu_one_id')->references('id')->on('menus');
            $table->foreign('footer_menu_two_id')->references('id')->on('menus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storefront_menus');
    }
}
