<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tax_id');
            $table->string('locale');
            $table->string('tax_class');
            $table->string('tax_name');
            $table->string('state');
            $table->string('city');
            $table->timestamps();

            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_translations');
    }
}
