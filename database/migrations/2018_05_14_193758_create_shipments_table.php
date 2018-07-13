<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_account_number');
            $table->string('waybill');
            $table->dateTime('delivery_date');
            $table->unsignedInteger('courier_id');
            $table->unsignedInteger('zone_id');
            $table->string('address_sub_text')->nullable();
            $table->string('address_maps_link')->nullable();
            $table->string('consignee_name');
            $table->string('phone_number')->nullable();
            $table->double('package_weight');
            $table->tinyInteger('service_type');
            $table->text('internal_notes')->nullable();
            $table->text('external_notes')->nullable();
            $table->tinyInteger('delivery_cost_lodger');
            $table->double('shipment_value');
            $table->double('price_of_address');
            $table->double('base_weight_of_zone');
            $table->double('charge_per_unit_of_zone');
            $table->double('extra_fees_per_unit_of_zone');
            $table->double('actual_paid_by_consignee')->default(0)->nullable();

            $table->unsignedTinyInteger('status_id');
            $table->unsignedTinyInteger('sub_status_id')->nullable();
            $table->text('status_notes')->nullable();

            $table->boolean('courier_cashed')->default(false);
            $table->boolean('client_paid')->default(false);

            $table->softDeletes();
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
        Schema::dropIfExists('shipments');
    }
}
