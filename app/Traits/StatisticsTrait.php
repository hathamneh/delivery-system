<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 20/08/18
 * Time: 12:05 م
 */

namespace App\Traits;


use App\Client;
use App\Status;
use Carbon\Carbon;

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

        $out = (object)[
            'shipments' => $this->shipmentsStats(),
            'pickups' => $this->pickupsStats(),
            'dueFrom' => $this->dueFromStats(),
            'dueFor' => $this->dueForStats(),
            'statuses' => $this->statsStatuses(),
        ];
        return $out;
    }

    public function prepareDateRanges(Carbon $begin, Carbon $until)
    {
        $this->statsPeriod = $period = $until->diffInDays($begin);
        $this->statsCurrentRange = [$begin, $until];
        $this->statsPreviousRange = [$begin->copy()->subDays($period), $until->copy()->subDays($period)];
    }

    public function shipmentsStats()
    {
        $this->statsShipmentsCount = $current = $this->shipments()->whereBetween('created_at', $this->statsCurrentRange)->count();
        $previous = $this->shipments()->whereBetween('created_at', $this->statsPreviousRange)->count();
        $ratio = $this->statsRatio($current, $previous);

        return [
            'current' => $current,
            'previous' => $previous,
            'ratio' => $ratio,
            'state' => $ratio > 0 ? "up" : "down"
        ];
    }

    public function pickupsStats()
    {

        $current = $this->pickups()->whereBetween('created_at', $this->statsCurrentRange)->count();
        $previous = $this->pickups()->whereBetween('created_at', $this->statsPreviousRange)->count();
        $ratio = $this->statsRatio($current, $previous);

        return [
            'current' => $current,
            'previous' => $previous,
            'ratio' => $ratio,
            'state' => $ratio > 0 ? "up" : "down"
        ];
    }

    public function dueForStats()
    {

        $current = $this->dueFor($this->statsCurrentRange);
        $previous = $this->dueFor($this->statsPreviousRange);
        $ratio = $this->statsRatio($current, $previous);

        return [
            'current' => $current,
            'previous' => $previous,
            'ratio' => $ratio,
            'state' => $ratio > 0 ? "up" : "down"
        ];
    }

    public function dueFromStats()
    {

        $current = $this->dueFrom($this->statsCurrentRange);
        $previous = $this->dueFrom($this->statsPreviousRange);
        $ratio = $this->statsRatio($current, $previous);

        return [
            'current' => $current,
            'previous' => $previous,
            'ratio' => $ratio,
            'state' => $ratio > 0 ? "up" : "down"
        ];
    }

    public function statsRatio($value1, $value2)
    {
        if ($value2 == 0) {
            if ($value1 == 0) return 0;
            return 100;
        }
        $diff = floatval($value1) - floatval($value2);
        $div = floatval($diff) / floatval($value2);
        return $div * 100;
    }

    /**
     * @return array
     */
    public function statsStatuses()
    {
        $out = [
            'labels' => [],
            'values' => [],
        ];
        $statuses = Status::get(['id', 'name']);
        foreach ($statuses as $status) {
            $shipments = $this->shipments()->whereBetween('created_at', $this->statsCurrentRange);
            $out['labels'][] = '"' . trans("shipment.statuses.{$status->name}.name") . '"';
            if ($this->statsShipmentsCount > 0) {
                $count = $shipments->whereStatusId($status->id)->count();
                //$out['values'][] = round(100 * ($count / $this->statsShipmentsCount), 2);
                $out['values'][] = $count;

            } else
                $out['values'][] = 0;
        }
        return $out;
    }
}