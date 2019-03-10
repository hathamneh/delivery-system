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

        \App\Status::truncate();

        \App\Status::create([
            'name'    => "picked_up",
            'groups'  => ["processing"],
            'options' => [],
        ]);
        \App\Status::create([
            'name'    => "received",
            'groups'  => ["processing", "returned", "pending"],
            'options' => [
                'set_branch' => true
            ],
        ]);
        \App\Status::create([
            'name'    => "departed",
            'groups'  => ["processing", "returned", "pending"],
            'options' => [
                'set_branch' => true
            ],
        ]);
        \App\Status::create([
            'name'    => "collect_from_office",
            'groups'  => ["in_transit", "returned", "pending", "courier"],
            'options' => [
                'set_branch' => true
            ],
        ]);
        \App\Status::create([
            'name'    => "collected_from_office",
            'groups'  => ["delivered", "returned"],
            'options' => [
                'set_branch' => true
            ],
        ]);
        \App\Status::create([
            'name'    => "out_for_delivery",
            'groups'  => ["in_transit", "returned", "pending"],
            'options' => [],
        ]);
        \App\Status::create([
            'name'    => "ready",
            'groups'  => ["in_transit", "courier", "returned", "pending"],
            'options' => [
                'set_time' => true
            ],
        ]);
        \App\Status::create([
            'name'    => "rescheduled",
            'groups'  => ["in_transit", "courier", "returned"],
            'options' => [
                'select'            => [
                    'rescheduled_by' => ['By Consignee', 'By Sender', 'By Kangaroo']
                ],
                'set_delivery_date' => true
            ]
        ]);
        \App\Status::create([
            'name'    => "not_available",
            'groups'  => ["in_transit", "courier", "returned"],
            'options' => [
                'select' => [
                    'reason' => [
                        "Transferred calls",
                        "Number blocked",
                        "No answer",
                        "Incorrect number",
                        "Invalid number",
                        "Number disconnected",
                        "No signal/coverage",
                        "Mobile switched off",
                    ],
                ],
            ]
        ]);
        \App\Status::create([
            'name'    => "cancelled",
            'groups'  => ["in_transit", "courier"],
            'options' => [
                'select' => [
                    'reason' => [
                        "Sender cancelled the shipment",
                        "Consignee is not expecting the shipment",
                        "Consignee wants to amend order before delivery",
                        "Consignee changed his/her mind",
                        "Repeated shipment"
                    ],
                ]
            ]
        ]);
        \App\Status::create([
            'name'    => "rejected",
            'groups'  => ["in_transit", "courier", "returned"],
            'options' => [
                'select' => [
                    'reason' => [
                        "Consignee didn't answer on arrival",
                        "Consignee cancelled on arrival",
                        "Consignee's mobile is switched off on arrival",
                        "Incorrect/missing item",
                        "Price issue",
                        "Damaged",
                        "Insufficient money",
                        "Consignee refused to pay",
                        "Consignee is not expecting shipment",
                        "Consignee mobile is transferred",
                        "Consignee wanted to receive shipment before paying",
                    ]
                ]
            ]
        ]);
        \App\Status::create([
            'name'    => "failed",
            'groups'  => ["in_transit", "courier", "returned"],
            'options' => [
                'select' => [
                    'reason' => [
                        "Bad weather conditions",
                        "Unreachable destination",
                        "Incomplete address",
                        "No phone number"
                    ],
                ],
            ],
        ]);

        \App\Status::create([
            'name'    => "delivered",
            'groups'  => ["delivered", "courier", "returned"],
            'options' => [],
        ]);

        \App\Status::create([
            'name'    => "customs",
            'groups'  => ["processing"],
            'options' => [],
        ]);


        \App\Status::create([
            'name'    => "on_hold",
            'groups'  => ["in_transit", "returned"],
            'options' => [
                'select' => [
                    'reason' => [
                        "Consignee rescheduled",
                        "Kangaroo rescheduled",
                        "Sender rescheduled",
                        "Consignee cancelled shipment, awaiting sender's instructions",
                        "Consignee rejected shipment, awaiting sender's instructions",
                        "Consignee not available, awaiting sender's instructions",
                        "Delivery failed",
                        "Consignee asked to collect shipment from office",
                        "Incomplete address, awaiting admin instructions",
                        "No phone number, awaiting admin instructions",
                        "Consignee contacted to set delivery address"
                    ],
                ],
            ],
        ]);
    }
}
