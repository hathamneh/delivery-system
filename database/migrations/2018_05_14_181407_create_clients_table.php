<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('account_number')->unique();
            $table->string('name');
            $table->string('trade_name')->unique();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_sub')->nullable();
            $table->string('address_maps')->nullable();
            $table->string('address_pickup_text')->nullable();
            $table->string('address_pickup_maps')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('sector')->nullable();
            $table->tinyInteger('category')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_client_name')->nullable();
            $table->string('bank_iban')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
