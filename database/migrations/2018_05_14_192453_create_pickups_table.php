<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier');
            $table->unsignedInteger("client_account_number")->nullable();
            $table->unsignedInteger("courier_id")->nullable();
            $table->unsignedInteger("expected_packages_number");
            $table->unsignedInteger('actual_packages_number')->nullable();
            $table->double("pickup_fees")->default(0)->nullable();
            $table->dateTime("available_time_start");
            $table->dateTime("available_time_end");
            $table->text("notes_internal")->nullable();
            $table->text("notes_external")->nullable();
            $table->string("phone_number");
            $table->enum("pickup_from", ['client', 'customer']);
            $table->string("pickup_address_text")->nullable();
            $table->string("pickup_address_maps")->nullable();
            $table->boolean("is_fees_paid")->default(false);
            $table->enum('status', ['pending', 'completed', 'declined_client', 'declined_dispatcher', 'declined_not_available'])->default("pending");
            $table->boolean('alerted')->default(false);
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
        Schema::dropIfExists('pickups');
    }
}
