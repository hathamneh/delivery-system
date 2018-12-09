<?php
/**
 * Get number with two decimals
 * @param float $number
 * @param int $decimals
 * @return string
 */
function fnumber(float $number, int $decimals = 2): string
{
    return number_format($number, $decimals);
}