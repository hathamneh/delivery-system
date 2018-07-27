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
            $table->enum('type', ['normal', 'guest', 'returned', 'prepaid']);

            $table->unsignedInteger('client_account_number');
            $table->unsignedInteger('courier_id');

            $table->string('waybill')->unique();
            $table->dateTime('delivery_date');

            $table->unsignedInteger('address_id');
            $table->text('address_sub_text')->nullable();
            $table->string('address_maps_link')->nullable();

            $table->string('consignee_name');
            $table->string('phone_number')->nullable();

            $table->text('internal_notes')->nullable();
            $table->text('external_notes')->nullable();

            $table->enum('service_type', ['nextday','sameday']);
            $table->enum('delivery_cost_lodger', ['client', 'courier']);

            $table->double('package_weight');
            $table->double('shipment_value');

            $table->double('price_of_address')->nullable();
            $table->double('base_weight_of_zone')->nullable();
            $table->double('charge_per_unit_of_zone')->nullable();
            $table->double('extra_fees_per_unit_of_zone')->nullable();
            $table->double('total_price')->nullable();

            $table->double('actual_paid_by_consignee')->default(0)->nullable();

            $table->unsignedTinyInteger('status_id');
            $table->unsignedTinyInteger('sub_status_id')->nullable();
            $table->text('status_notes')->nullable();

            $table->boolean('courier_cashed')->default(false);
            $table->boolean('client_paid')->default(false);

            $table->unsignedInteger('returned_from')->nullable();

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
