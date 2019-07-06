<?php

use Illuminate\Support\Facades\DB;
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
            $table->increments('account_number');
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

            $table->string('url_facebook')->nullable();
            $table->string('url_instagram')->nullable();
            $table->string('url_website')->nullable();

            $table->unsignedInteger('zone_id');
            $table->string('sector')->nullable();
            $table->tinyInteger('category')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_holder_name')->nullable();
            $table->string('bank_iban')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE clients AUTO_INCREMENT = 10000;");
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
