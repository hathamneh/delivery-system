<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_account_number');
            $table->unsignedInteger('custom_zone_id');
            $table->unsignedInteger('address_id')->nullable();
            $table->string('name')->nullable();
            $table->double('sameday_price')->nullable();
            $table->double('scheduled_price')->nullable();
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
        Schema::dropIfExists('custom_addresses');
    }
}
