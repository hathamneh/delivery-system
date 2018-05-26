<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_zone', function (Blueprint $table) {
            $table->unsignedInteger('client_id');
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
        Schema::dropIfExists('client_zones');
    }
}
