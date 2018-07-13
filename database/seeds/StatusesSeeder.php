<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Status::create([
            'name'              => "picked_up",
            'description'       => "Shipment Picked Up",
            'unpaid'            => false,
            'pending'           => false,
            'courier_dashboard' => false,
        ]);
        \App\Status::create([
            'name'        => "received",
            'description' => "Received at operation facility",
            'unpaid'            => false,
            'pending'           => true,
            'courier_dashboard' => true,
        ]);
        $status = \App\Status::create([
            'name'        => "on_hold",
            'description' => "Attempted to deliver shipment",
            'unpaid'            => false,
            'pending'           => true,
            'courier_dashboard' => false,
        ]);
        $status->subStatuses()->create([
            'name'              => 'consignee_rescheduled',
            'has_date'          => true,
            'suggested_reasons' => [
                'Insufficient Amount',
                'Not Ready to receive shipment',
                'To be collected from office',
            ]
        ]);
        $status->subStatuses()->create([
            'name'              => 'not_available',
            'has_date'          => false,
            'suggested_reasons' => [
                'SMS Sent',
                'Mobile switched off',
                'No Answer',
                'No Coverage',
                'Incorrect Number',
                'Blocked',
                'Transferred Calls',
            ]
        ]);

        \App\Status::create([
            'name'              => "cancelled",
            'description'       => "Shipment has been cancelled",
            'suggested_reasons' => [
                "Requested by sender",
                "Consignee is not expecting the shipment",
                "Consignee informed sender for cancellation",
            ],
            'unpaid'            => false,
            'pending'           => false,
            'courier_dashboard' => true,
        ]);
        \App\Status::create([
            'name'              => "rejected",
            'description'       => "Shipment has been rejected",
            'suggested_reasons' => [
                "Incorrect / missing item",
                "Price issue",
                "Damaged",
                "Insufficient money",
                "Refused to pay"
            ],
            'unpaid'            => true,
            'pending'           => false,
            'courier_dashboard' => false,
        ]);
        \App\Status::create([
            'name'              => "failed",
            'description'       => "Delivery Failed",
            'suggested_reasons' => [
                "Bad weather conditions",
                "Unreachable destination"
            ],
            'unpaid'            => false,
            'pending'           => false,
            'courier_dashboard' => false,
        ]);
        \App\Status::create([
            'name'        => "delivered",
            'description' => "Shipment has delivered to consignee successfully",
            'unpaid'            => true,
            'pending'           => false,
            'courier_dashboard' => true,
        ]);
        \App\Status::create([
            'name'        => "returned",
            'description' => "Consignee has returned the shipment to sender",
            'unpaid'            => true,
            'pending'           => false,
            'courier_dashboard' => true,
        ]);
    }
}
