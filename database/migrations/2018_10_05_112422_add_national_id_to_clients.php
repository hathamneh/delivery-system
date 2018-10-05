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
        Schema::table('client', function (Blueprint $table) {
            $table->string('national_id')->nullable();
        });
        Schema::table('guest', function (Blueprint $table) {
            $table->string('national_id')->nullable();
        });
        Schema::table('pickup', function (Blueprint $table) {
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
        Schema::table('client', function (Blueprint $table) {
            $table->dropColumn('national_id');
        });
        Schema::table('guest', function (Blueprint $table) {
            $table->dropColumn('national_id');
        });
        Schema::table('pickup', function (Blueprint $table) {
            $table->dropColumn('client_national_id');
        });
    }
}
