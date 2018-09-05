<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_account_number');
            $table->unsignedInteger('zone_id');
            $table->double('base_weight')->nullable();
            $table->double('charge_per_unit')->nullable();
            $table->double('extra_fees_per_unit')->nullable();
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
        Schema::dropIfExists('custom_zones');
    }
}
