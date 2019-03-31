<?php
/**
 * Get number with two decimals
 * @param float $number
 * @param int $decimals
 * @return string
 */
function fnumber($number, int $decimals = 2): string
{
    if(is_null($number)) return 0;
    return number_format($number, $decimals);
}