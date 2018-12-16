<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourierZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courier_zone', function (Blueprint $table) {
            $table->unsignedInteger('courier_id');
            $table->unsignedInteger('zone_id');
            $table->foreign('courier_id')->references('id')->on('couriers')->onDelete('cascade');
        });
        Schema::table('couriers', function (Blueprint $table) {
            $table->dropColumn('zone_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courier_zone');
    }
}
