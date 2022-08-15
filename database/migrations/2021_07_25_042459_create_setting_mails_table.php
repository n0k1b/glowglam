<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_mails', function (Blueprint $table) {
            $table->id();
            $table->string('mail_address')->nullable();
            $table->string('mail_name')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_encryption')->nullable();
            $table->tinyInteger('welcome_email')->nullable();
            $table->tinyInteger('new_order_to_admin')->nullable();
            $table->tinyInteger('invoice_mail')->nullable();
            $table->string('mail_order_status')->nullable();
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
        Schema::dropIfExists('setting_mails');
    }
}
