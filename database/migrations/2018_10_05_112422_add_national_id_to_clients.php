<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNationalIdToClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('national_id')->nullable();
        });
        Schema::table('guests', function (Blueprint $table) {
            $table->string('national_id')->nullable();
        });
        Schema::table('pickups', function (Blueprint $table) {
            $table->string('client_national_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('national_id');
        });
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('national_id');
        });
        Schema::table('pickups', function (Blueprint $table) {
            $table->dropColumn('client_national_id');
        });
    }
}
