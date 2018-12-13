<?php

namespace App\Http\Controllers;


use App\Client;
use App\Guest;
use App\Service;
use App\Shipment;
use App\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipmentFilters
{

    public $filters = [
        'scope' => [],
        'client' => '',
        'service' => ''
    ];

    public function applyFilters(&$shipments, Request $request)
    {


        foreach (array_keys($this->filters) as $filterKey) {
            $methodName = "apply" . ucfirst($filterKey) . "Filter";
            if (method_exists($this, $methodName))
                $this->$methodName($shipments, $request->get($filterKey, false));
        }

        return $this->filters;
    }

    /**
     * @param Shipment $shipments
     * @param $data
     */
    protected function applyScopeFilter(&$shipments, $data)
    {
        if ($data) {
            $this->filters['scope'] = explode(',', $data);
            $or = false;
            foreach ($this->filters['scope'] as $scope) {
                if ($scope === "pending")
                    $shipments = $shipments->pending();
                elseif (Status::name($scope)->exists()) {
                    $shipments = $shipments->statusIn([$scope], $or ? "or" : "and");
                }
                $or = true;
            }
        }
    }

    /**
     * @param Shipment $shipments
     * @param $data
     */
    protected function applyClientFilter(&$shipments, $data)
    {
        if ($data) {
            $this->filters['client'] = $data;
            if (!is_null(Client::find($data)))
                $shipments->where('client_account_number', '=', $data);
            if (!is_null($guest = Guest::whereNationalId($data)->first()))
                $shipments->where('client_account_number', '=', $guest->id);
        }
    }

    /**
     * @param Shipment $shipments
     * @param $data
     */
    protected function applyServiceFilter(&$shipments, $data)
    {
        if ($data) {
            $this->filters['service'] = intval($data);
            if (!is_null(Service::find($data))) {
                $ids = DB::table('service_shipment')->where('service_id', $data)->pluck('shipment_id');
                $shipments->whereIn('id', $ids);
            }
        }
    }

    public function filtersData(...$extend)
    {
        $out = [
            'statuses' => Status::all(),
            'services' => Service::all(),
        ];
        if (count($extend))
            foreach ($extend as $item) {
                $out = array_merge($out, $item);
            }
        return $out;
    }
}

