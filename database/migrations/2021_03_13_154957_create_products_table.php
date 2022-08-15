<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('tax_class_id')->nullable();
            $table->string('slug');
            $table->decimal('price');
            $table->decimal('special_price')->nullable();
            $table->string('special_price_type')->nullable();
            $table->date('special_price_start')->nullable();
            $table->date('special_price_end')->nullable();
            $table->decimal('selling_price')->nullable();
            $table->string('sku')->nullable();
            $table->tinyInteger('manage_stock')->nullable(); //Nullable remove later
            $table->integer('qty')->nullable(); 
            $table->tinyInteger('in_stock')->nullable(); //Nullable remove later
            $table->integer('viewed')->nullable(); //Nullable remove later
            $table->tinyInteger('is_active');
            $table->dateTime('new_from')->nullable();
            $table->dateTime('new_to')->nullable();
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands');
            // $table->foreign('tax_class_id')->references('id')->on('tax_classes'); //Will be update later
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
