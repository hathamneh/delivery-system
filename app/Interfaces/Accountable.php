<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 11/08/18
 * Time: 08:40 م
 */

namespace App\Interfaces;


use App\Invoice;

interface Accountable
{
    /**
     * @param Invoice $invoice
     * @return float
     */
    public function dueFrom(Invoice $invoice) : float ;

    /**
     * @param Invoice $invoice
     * @return float
     */
    public function dueFor(Invoice $invoice) : float ;
}