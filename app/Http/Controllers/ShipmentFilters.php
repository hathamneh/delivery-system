<?php

namespace App\Http\Controllers;


use App\Client;
use App\Guest;
use App\Service;
use App\Shipment;
use App\Status;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShipmentFilters
{

    public $filters = [
        'scope' => [],
        'client' => '',
        'service' => '',
        'types' => []
    ];

    public static $appliedFilters = [];

    public function applyFilters(&$shipmentsQuery, $appliedFilters)
    {
        foreach (array_keys($this->filters) as $filterKey) {
            $methodName = "apply" . ucfirst($filterKey) . "Filter";
            if (array_key_exists($filterKey, $appliedFilters) && method_exists($this, $methodName)) {
                $this->$methodName($shipmentsQuery, $appliedFilters[$filterKey]);
            }
        }

        static::$appliedFilters = $this->filters;
        return $this->filters;
    }

    /**
     * @param Shipment $shipmentsQuery
     * @param $data
     */
    protected function applyScopeFilter(&$shipmentsQuery, $data)
    {
        if ($data) {
            $this->filters['scope'] = explode(',', $data);
            $or = false;
            foreach ($this->filters['scope'] as $scope) {
                if ($scope === "pending")
                    $shipmentsQuery = $shipmentsQuery->pending();
                elseif (Status::name($scope)->exists()) {
                    $shipmentsQuery = $shipmentsQuery->statusIn([$scope], $or ? "or" : "and");
                }
                $or = true;
            }
        }
    }

    /**
     * @param Shipment $shipmentsQuery
     * @param $data
     */
    protected function applyClientFilter(&$shipmentsQuery, $data)
    {
        if ($data) {
            $this->filters['client'] = $data;
            if (!is_null(Client::find($data)))
                $shipmentsQuery->where('client_account_number', '=', $data);
            if (!is_null($guest = Guest::whereNationalId($data)->first()))
                $shipmentsQuery->where('client_account_number', '=', $guest->id);
        }
    }

    /**
     * @param Shipment $shipmentsQuery
     * @param $data
     */
    protected function applyServiceFilter(&$shipmentsQuery, $data)
    {
        if ($data) {
            $this->filters['service'] = intval($data);
            if (!is_null(Service::find($data))) {
                $ids = DB::table('service_shipment')->where('service_id', $data)->pluck('shipment_id');
                $shipmentsQuery->whereIn('id', $ids);
            }
        }
    }

    /**
     * @param Shipment $shipmentsQuery
     * @param string [$data]
     */
    public function applyTypesFilter(&$shipmentsQuery, $data = null)
    {
        if (is_null($data)) return;

        $types = !empty($data) ? explode(",", $data) : ['normal', 'guest'];

        $shipmentsQuery->type($types);

        $this->filters['types'] = $types;

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

