<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_limits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_account_number');
            $table->string('name');
            $table->float('value');
            $table->json('appliedOn')->nullable();
            $table->float('penalty')->nullable();
            $table->timestamps();

            $table->foreign('client_account_number')
                ->references('account_number')
                ->on('clients')
                ->onDelete('cascade');
        });

        Schema::table('clients', function (Blueprint $table){
            $table->dropColumn('min_delivery_cost');
            $table->dropColumn('max_returned_shipments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_limits');
    }
}
