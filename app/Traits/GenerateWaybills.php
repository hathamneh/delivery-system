<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait GenerateWaybills
{

    protected $waybill_default_digits = 9;

    /**
     * @param int $index
     * @return int
     */
    public function generateWaybill(int $index)
    {
        $waybill_digits = $this->waybill_digits ?? $this->waybill_default_digits;

        $value = $index % 7 + $index * 10;
        $value_padded = str_pad(strval($value), $waybill_digits, "0", STR_PAD_LEFT);
        if (isset($this->waybill_prefix))
            return intval($this->waybill_prefix . $value_padded);
        else
            return intval($value_padded);
    }

    /**
     * @param int $start
     * @param int $count
     * @return array
     */
    public function generateWaybillRange(int $start, int $count)
    {
        $arr = [];
        for ($i = $start; $i < $start + $count; $i++)
            $arr[] = self::generateWaybill($i);
        return $arr;
    }

    public function generateNextWaybill()
    {
        $type = $this->waybill_type ?? "normal";
        $latestId = DB::table((new static)->getTable())->where('type', $type)->latest()->limit(1)->value('id');
        $index = $latestId ?? 0;
        return self::generateWaybill($index);
    }
}