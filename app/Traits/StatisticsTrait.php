<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 20/08/18
 * Time: 12:05 م
 */

namespace App\Traits;


use App\Client;
use App\Courier;
use App\Shipment;
use App\Status;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait StatisticsTrait
{

    /**
     * @var array
     */
    private $statsCurrentRange;

    /**
     * @var array
     */
    private $statsPreviousRange;

    /**
     * @var integer
     */
    private $statsPeriod;

    /**
     * @var integer
     */
    private $statsShipmentsCount;


    /**
     * @param Carbon $begin
     * @param Carbon $until
     * @return object
     */
    public function statistics(Carbon $begin, Carbon $until)
    {
        $this->prepareDateRanges($begin, $until);

        $out = [
            'shipments' => $this->shipmentsStats(),
            'pickups'   => $this->pickupsStats(),
            'dueFrom'   => $this->dueFromStats(),
            'dueFor'    => $this->dueForStats(),
            'statuses'  => $this->statsStatuses(),
        ];
        if ($this instanceof Courier)
            $out['achievement'] = $this->achievementStats();
        return (object)$out;
    }

    public function prepareDateRanges(Carbon $begin, Carbon $until)
    {
        $this->statsPeriod        = $period = $until->diffInDays($begin);
        $this->statsCurrentRange  = [$begin, $until];
        $this->statsPreviousRange = [$begin->copy()->subDays($period), $until->copy()->subDays($period)];
    }

    public function shipmentsStats()
    {
        $this->statsShipmentsCount = $current = $this->shipments()->whereBetween('created_at', $this->statsCurrentRange)->count();
        $previous                  = $this->shipments()->whereBetween('created_at', $this->statsPreviousRange)->count();
        $ratio                     = $this->statsRatio($current, $previous);

        return [
            'current'  => $current,
            'previous' => $previous,
            'ratio'    => $ratio,
            'state'    => $ratio > 0 ? "up" : "down"
        ];
    }

    public function achievementStats()
    {
        $allCurrent                 = $this->shipments()->whereBetween('created_at', $this->statsCurrentRange)->get();
        $allPrevious                = $this->shipments()->whereBetween('created_at', $this->statsPreviousRange)->get();
        $deliveredShipmentsCurrent  = $allCurrent->where('status_id', Status::name('delivered')->first()->id)->count();
        $deliveredShipmentsPrevious = $allPrevious->where('status_id', Status::name('delivered')->first()->id)->count();

        return [
            'current'  => $allCurrent->count() ? round(100 * $deliveredShipmentsCurrent / $allCurrent->count(), 2) : 0,
            'previous' => $allPrevious->count() ? round(100 * $deliveredShipmentsPrevious / $allPrevious->count(), 2) : 0,
        ];
    }

    public function pickupsStats()
    {

        $current  = $this->pickups()->whereBetween('created_at', $this->statsCurrentRange)->count();
        $previous = $this->pickups()->whereBetween('created_at', $this->statsPreviousRange)->count();
        $ratio    = $this->statsRatio($current, $previous);

        return [
            'current'  => $current,
            'previous' => $previous,
            'ratio'    => $ratio,
            'state'    => $ratio > 0 ? "up" : "down"
        ];
    }

    public function dueForStats()
    {

        $current  = $this->dueFor($this->statsCurrentRange);
        $previous = $this->dueFor($this->statsPreviousRange);
        $ratio    = $this->statsRatio($current, $previous);

        return [
            'current'  => $current,
            'previous' => $previous,
            'ratio'    => $ratio,
            'state'    => $ratio > 0 ? "up" : "down"
        ];
    }

    public function dueFromStats()
    {

        $current  = $this->dueFrom($this->statsCurrentRange);
        $previous = $this->dueFrom($this->statsPreviousRange);
        $ratio    = $this->statsRatio($current, $previous);

        return [
            'current'  => $current,
            'previous' => $previous,
            'ratio'    => $ratio,
            'state'    => $ratio > 0 ? "up" : "down"
        ];
    }

    public function statsRatio($value1, $value2)
    {
        if ($value2 == 0) {
            if ($value1 == 0) return 0;
            return 100;
        }
        $diff = floatval($value1) - floatval($value2);
        $div  = floatval($diff) / floatval($value2);
        return round($div * 100, 2);
    }

    /**
     * @return array
     */
    public function statsStatuses()
    {
        $labels   = [];
        $stats    = [];
        $statuses = Status::get(['id', 'name']);
        foreach ($statuses as $status) {
            $stats[$status->name] = [
                'label' => trans("shipment.statuses.{$status->name}.name"),
                'data'  => []
            ];
        }
        $period    = new \DatePeriod($this->statsCurrentRange[0], CarbonInterval::day(), $this->statsCurrentRange[1]->addDay());
        $shipments = $this->shipments()->whereBetween('created_at', $this->statsCurrentRange)->get();
        foreach ($period as $dt) {
            $date     = new Carbon($dt);
            $labels[] = '"' . $date->format("m/d") . '"';
            /** @var Builder $shipments */
            foreach ($statuses as $status) {
                /** @var Collection $selected */
                $selected                       = $shipments->where('status_id', '=', $status->id)
                    ->where('created_at', '>=', $date->startOfDay())
                    ->where('created_at', '<=', $date->endOfDay());
                $stats[$status->name]['data'][] = $selected->count();
            }
        }


        $out = [
            'labels' => $labels,
            'values' => $stats,
        ];
        return $out;
    }
}