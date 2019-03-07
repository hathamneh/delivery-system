<?php

return [
    'label'   => 'Shipments',
    'all'     => 'All Shipments',
    'single'  => "Shipment",
    'new'     => 'New Shipment',
    'save'    => 'Save Shipment',
    'edit'    => 'Edit Shipment',
    'updated' => "{0} Nothing updated|{1} <i class='fa-check-circle2'></i> One shipment updated successfully.|[2,*] <i class='fa-check-circle2'></i> :value shipments updated successfully.",
    'info'    => "Shipment Info",

    'created_on' => 'Created On',
    'created_by' => 'Created By',

    'track_shipment'           => "Track Your Shipment",
    "enter_identifier"         => "Please Enter Shipment Waybill Number",
    "detailsNote"              => "Please fill consignee's information carefully:",
    "delivery_details"         => "Delivery Details",
    "client_info"              => "Client Info",
    "details"                  => "Consignee's information",
    "service_type"             => "Service Type",
    "service_types"            => [
        "label"   => "Service Type",
        "nextday" => "Next Day Delivery",
        "sameday" => "Same Day Delivery",
        "help"    => "When this shipment should be deliverd?",
    ],
    "delivery_cost_lodger"     => [
        "label"   => "Delivery Cost Lodger",
        "client"  => "Client",
        "courier" => "Courier",
        "help"    => "Who's responsible for collecting money?",
    ],
    'courier'                  => "Courier",
    'couriers'                 => [
        'label' => "Courier",
        "help"  => "Select the courier responsible for delivering this shipment."
    ],
    'review'                   => 'Review Shipment',
    "reviewNote"               => "Review the data you have entered for this shipment before submitting",
    "client_placeholder"       => "Find client by account number",
    "existing_client"          => "Existing Client",
    "client_account_number"    => "Client Account Number",
    "external_client"          => "Not-registered Client",
    'client'                   => [
        'type'    => "Type",
        'name'    => "Name",
        'phone'   => "Phone Number",
        'country' => "Country",
        'city'    => "City",
    ],
    'waybill'                  => "Waybill number",
    'delivery_date'            => "Delivery Date",
    'package_weight'           => "Package Weight (KG)",
    'shipment_value'           => "Shipment Value",
    'delivery_cost'            => "Delivery Cost",
    'actual_paid'              => "Paid By Consignee",
    'actual_paid_by_consignee' => "Paid By Consignee",
    'status'                   => "Status",
    'initial_status'           => "Initial Status",
    'statuses'                 => [
        'picked_up'             => [
            "name"        => "Picked Up",
            "description" => "Shipment Picked Up"],
        'received'              => [
            "name"        => "Received",
            "description" => "Received at operation facility"],
        'departed'              => [
            "name"        => "Departed",
            "description" => "Departed operation facility"],
        'out_for_delivery'      => [
            "name"        => "Out for delivery",
            "description" => "Shipment on its way to consignee"],
        'ready'                 => [
            "name"        => "Ready",
            "description" => "Ready for delivery/Consignee contacted"],
        'on_hold'               => [
            "name"        => "On Hold",
            "description" => "Shipment is on hold"],
        'cancelled'             => [
            "name"        => "Cancelled",
            "description" => "Shipment has been cancelled"],
        'rejected'              => [
            "name"        => "Rejected",
            "description" => "Shipment has been rejected"],
        'failed'                => [
            "name"        => "Failed",
            "description" => "Delivery Failed"],
        'delivered'             => [
            "name"        => "Delivered",
            "description" => "Shipment has delivered to consignee successfully"],
        'returned'              => [
            "name"        => "Returned",
            "description" => "Shipment is returned"],
        'rescheduled'           => [
            "name"        => "Rescheduled",
            "description" => "Delivery time has been rescheduled"],
        'not_available'         => [
            "name"        => "Not Available",
            "description" => "The consignee is not available to receive the shipment"],
        'collect_from_office'   => [
            "name"        => "Office Collection",
            "description" => "Consignee asked to collect shipment from office"],
        'collected_from_office' => [
            "name"        => "Collected From Office",
            "description" => "Has been collected from office"],
        'customs'               => [
            "name"        => "Customs office",
            "description" => "Customs Office Processing"],
    ],
    "status_groups"            => [
        "processing" => "Processing",
        "in_transit" => "In Transit",
        "delivered"  => "Delivered"
    ],
    "statuses_options"         => [
        "reason"         => "Reason",
        "rescheduled_by" => "Rescheduled By",
        "set_branch"     => "Set Branch"
    ],
    'consignee_name'           => "Consignee Name",
    'phone_number'             => "Phone Number",
    'address'                  => "Select Address",
    'address_maps_link'        => "Google Maps Link",
    'address_sub_text'         => "Detailed Address",
    'extra_services'           => "Extra Services",
    'select_multi_service'     => "You can select multiple services...",

    'log'                    => "Shipment Lifecycle",
    'client_notes'           => "Client Notes",
    'internal_notes'         => "Notes for Courier",
    'external_notes'         => "Notes from Courier",
    'price_of_address'       => "Price Of Address",
    'fees'                   => "Fees",
    'services_cost'          => "Services Cost",
    'total'                  => "Total",
    'actions'                => "Shipment Actions",
    'change_status'          => "Change Status",
    'change_status_manually' => "Change Status Manually",
    "sub_status"             => "Sub Status",
    "status_notes"           => "Reasons for this status",
    "extra_notes"            => "Extra Notes",
    "summery"                => "Shipment Summery",
    "returned"               => "Returned Shipments",
    "return"                 => "Return Shipment",
    "make_returned"          => "Return this Shipment",
    "return_notice"          => "If this shipment is <b>rejected</b> or <b>cancelled</b> and you want to return it to the client, please click <b>Return this Shipment</b> to create another new shipment of type returned. This will help you in tracking.",
    "delete"                 => "Delete Shipment",
    "delete_notice"          => "When you delete the shipment all its data will be deleted and you will never be able to get them back.<br><b class='text-danger'>Please be certain!</b>",
    "change_original_status" => "What happened with this shipment?",
    "returnedDeliveryDate"   => "When the returned shipment will be delivered?",

    'shipments' => '{0} No shipments assigned|{1} One shipment assigned|[2,*] :value shipments assigned',

    'total_price'       => "Total Delivery Price",
    'custom_price'      => "Override delivery cost",
    'custom_price_help' => "Use this value for delivery cost instead of computing it.",
    'pieces'            => 'Number of Pieces',
    'courier_cashed'    => "Courier Cashed",
    'client_paid'       => "Client Paid",

    'delivery'              => "Shipment Delivery",
    'delivery_notice'       => "If you are delivering this shipment please choose the status of delivery.<p><b>Is this shipment delivered successfully?</b></p>",
    'delivered'             => "Yes, delivered successfully",
    'not_delivered'         => "No, not delivered",
    'make_delivered'        => "Set as delivered",
    'make_not_delivered'    => "Set as not delivered",
    'toggle_client_paid'    => "Toggle Client Paid",
    'toggle_courier_cashed' => "Toggle Courier Cashed",

    'assignCourier' => "<i class='fa fa-truck mr-2'></i> Assign Courier",

    'reference' => "Reference",
];